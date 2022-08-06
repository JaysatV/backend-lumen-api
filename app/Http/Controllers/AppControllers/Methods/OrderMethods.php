<?php


namespace App\Http\Controllers\AppControllers\Methods;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php';
require 'PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php';

use App\Models\AppModels\OrdersModel;
use App\Models\AppModels\OrderItemsModel;
use App\Models\AppModels\ProductsModel;
use App\Models\AppModels\CustomersModel;
use App\Models\AppModels\UnitsModel;
use App\Models\AppModels\CategoriesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


date_default_timezone_set('Asia/Kolkata');
class OrderMethods
{


    public function methodGetAllOrders(Request $request) {
        
        if($request->type == 'DATE') {
            
        $dateS = date('Y-m-d', strtotime($request->dateS))." 00:00:00";
        $dateE = date('Y-m-d', strtotime($request->dateE))." 23:59:59";
		$orders_model = OrdersModel::whereBetween('created_at', [$dateS, $dateE])->orderByDesc('id')->get();
        } else if($request->type == 'STATUS') {
            if( $request->status <= 3) {
                 $orders_model = OrdersModel::where('status', $request->status)->orderByDesc('id')->get();
            } else if( $request->status > 3) {
                 $orders_model = OrdersModel::where('is_paid', $request->isPaid)->orderByDesc('id')->get();
            }
           
           
        } else if($request->type == 'ALL') {
            $orders_model = OrdersModel::orderByDesc('id')->get();
        }
        
		$result_array = array();
		foreach($orders_model as $order) {
			$customer = CustomersModel::find($order->customer_id);
			$order['customer_details'] = $customer;
		}
		
	
	   
		return $orders_model;

        
    }
    
     public function methodGetCustomerOrders($phone_number) {

        
        if(count(CustomersModel::where('phone_number', $phone_number)->get()) > 0){
            $customer = CustomersModel::where('phone_number', $phone_number)->first();
            $orders_model = OrdersModel::where('customer_id', $customer->id)->orderByDesc('id')->get();
    		foreach ($orders_model as $order) {
              $order['order_items'] = $this->methodGetOrderItems($order->id);
            }
            return $orders_model;
        } else {
            return [];
        }

		
    }
	
	public function methodCreateOrder(Request $request) {
		$customer = CustomersModel::where('phone_number', '=',  $request->customer_details['phone_number'])->first();
		$customer_id = '';
		if($customer == null) {
			$new_customer = CustomersModel::create($request->customer_details);
			$customer_id = $new_customer->id;
		} else { 
			$customer_id = $customer->id;
		}
		$order_details = $request->order_detials;
		$order_details['customer_id'] = $customer_id;
		$order_details['customer_name'] = $request->customer_details['customer_name'];
		$order_details['customer_email'] = $request->customer_details['customer_email'];
		$order_details['delivery_address'] = $request->customer_details['delivery_address'];
		$new_order = OrdersModel::create($order_details);
		
		$table_name = 'order_items_'.$new_order->id;
		Schema::connection('mysql_order_items')->create($table_name, function($table)
			{
				$table->increments('id');
				$table->string('item_name');
				$table->float('item_rate');
				$table->float('item_discount');
				$table->float('item_discount_total');
				$table->integer('item_quantity');
				$table->float('item_total');
				$table->date('created_at');
				$table->date('updated_at')->nullable();
				$table->integer('created_by')->unsigned()->nullable();
			});
		
		$order_items_model = new OrderItemsModel();
		$order_items_model->setTable($table_name);
		foreach ($request->order_items as $items) {
			$order_items_model->create($items);
		}
		
		
	    $this->sendMail($request->customer_details['phone_number'], $new_order, $request->order_items);
		return $new_order;
	}
	
	
	public function methodGetOrderItems($order_id) {
		$table_name = 'order_items_'.$order_id;
		$order_items_model = new OrderItemsModel();
		$order_items_model->setTable($table_name);
		return $order_items_model->get();
	}
	
	public function updateOrder(Request $request){
	    return OrdersModel::where('id',$request->order_id)->update(json_decode(json_encode($request->order_data), true));
	}
	
	
	public function updateOrderItems(Request $request) {
	    $table_name = 'order_items_'.$request->order_id;
		$order_items_model = new OrderItemsModel();
		$order_items_model->setTable($table_name);
	    $result = $order_items_model->where('id',$request->item_id)->update(json_decode(json_encode($request->items_data), true));
	    if ($result > 0) {
	        $this->updateOrder($request);
	    }
	    return $result;
	}
	
	public function updateOrderItemsDiscount(Request $request) {
	    $table_name = 'order_items_'.$request->order_id;
		$order_items_model = new OrderItemsModel();
		$order_items_model->setTable($table_name);
		foreach ($request->items_data as $p) {
            $order_items_model->where('id',$p['id'])->update(json_decode(json_encode($p), true));
        }
 
	   
	    return $this->updateOrder($request);
	}
	
	public function methodDeleteOrderItem(Request $request) {
	    $table_name = 'order_items_'.$request->order_id;
	    $order_items_model = new OrderItemsModel();
		$order_items_model->setTable($table_name);
	    $result = $order_items_model->where('id', $request->item_id)->delete();
	    if ($result > 0) {
	        $this->updateOrder($request);
	    }
	    return $result;
	} 
	
	public function insertOrderItem(Request $request) {
	    $table_name = 'order_items_'.$request->order_id;
	    $order_items_model = new OrderItemsModel();
		$order_items_model->setTable($table_name);
		$order_items_model->create($request->order_item);
	    
	    return $this->updateOrder($request);
	}

    public function sendMail($phone_no, $new_order, $order_items) {
        
        
      
  		 require 'PHPMailer/vendor/autoload.php';
		$mail = new PHPMailer(true);


		                   //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = env('EMAIL_HOST');                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = env('EMAIL_USERNAME');                     //SMTP username
		$mail->Password   = env('EMAIL_PASSWORD');                              //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		$mail->Port       = 465;                                    //TCP port to connect to; use 587 old 465 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		//Recipients
		$mail->setFrom('jaysatofficial@gmail.com', 'Dharshini Crackers Shop');
		if($new_order->customer_email != '')
			$mail->addAddress($new_order->customer_email);     //Add a recipient
		$mail->addAddress('jaysat96@gmail.com');
		$mail->addAddress('dharshinicrackersshop@gmail.com');
	 //   $mail->addAddress('jaysatmail@gmail.com');               //Name is optional
	 //   $mail->addReplyTo('info@dharshinicrackersshop.com', 'Information');
	 //   $mail->addCC('jaysat96@gmail.com');
	 //   $mail->addBCC('jaysatofficial@gmail.com');

		$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
		);
		$mail->AuthType = 'LOGIN';
		//Content
		
		$subject = "New Order from Dharshini Crackers Shop";
        
        
        $items = array();
        $i = 0;
        foreach($order_items as $item) {
            array_push($items, '
            <tr style="border: 1px solid black;  border-collapse: collapse;">
            <td style="border: 1px solid black;  border-collapse: collapse;">'. ++$i .'</td>
             <td style="border: 1px solid black;  border-collapse: collapse;">'. $item['item_name'].'</td>
             <td style="border: 1px solid black;  border-collapse: collapse;">₹'. $item['item_rate'].'</td>
             <td style="border: 1px solid black;  border-collapse: collapse;">'. $item['item_discount'].'%</td>
             <td style="border: 1px solid black;  border-collapse: collapse;">'. $item['item_quantity'].'</td>
             <td style="border: 1px solid black;  border-collapse: collapse;">₹'. $item['item_total'].'</td>
             
              </tr>');
        }
       $message = '
            <html>
            <head>
              <title">congrats! New Order Placed</title>
             <style>
                table, th, td {
                    
                }
             </style>
            </head>
            <body>
              <p>Bill No: <strong>'. $new_order->id .'</strong></p>
              <p>Bill Date: <strong>'. $new_order->created_at .'</strong></p>
              <p>Customer Name: <strong>Mr/Mrs.'. $new_order->customer_name .'</strong></p>
              <p>Phone No: <strong>'. $phone_no  .'</strong></p>
              <p>Delivery Address: <strong>'. $new_order->delivery_address .'</strong></p>
              <p>Email: <strong>'. $new_order->customer_email .'</strong></p>
              <p>Total Amount: <strong>₹ '. $new_order->total_amount .'</strong></p>
               
        		
               <table style="border: 1px solid black;  border-collapse: collapse;">
                  <tr style="border: 1px solid black;  border-collapse: collapse;">
                    <th style="border: 1px solid black;  border-collapse: collapse;">S.No</th>
                    <th style="border: 1px solid black; border-collapse: collapse;">Item</th>
                    <th style="border: 1px solid black;  border-collapse: collapse;">Rate</th>
                    <th style="border: 1px solid black;  border-collapse: collapse;">Discount</th>
                    <th style="border: 1px solid black;  border-collapse: collapse;">Quantity</th>
                     <th style="border: 1px solid black;  border-collapse: collapse;">Total</th>
                     
                  </tr>
                   
                  
                   '. implode(" ",$items) .'
                    
                 <tr style="border: 1px solid black;  border-collapse: collapse;">
                    <th style="border: 1px solid black;  border-collapse: collapse;" colspan="4">Total</th>
                      <th style="border: 1px solid black;  border-collapse: collapse;">'. $new_order->items_count .'</th>
                     <th style="border: 1px solid black;  border-collapse: collapse;">₹'. $this->calcTotalAmount( $new_order->total_amount, $new_order->paf_charges ) .'</th>
                     
                  </tr>
                  
                  <tr style="border: 1px solid black;  border-collapse: collapse;">
                    <th style="border: 1px solid black;  border-collapse: collapse;" colspan="5">Packing and Forwarding Charges</th>
                      <th style="border: 1px solid black;  border-collapse: collapse;">(+) ₹'. $new_order->paf_charges .'</th>
                     
                  </tr>
                
                <tr style="border: 1px solid black;  border-collapse: collapse;">
                    <th style="border: 1px solid black;  border-collapse: collapse;" colspan="5">Total Amount</th>
                      <th style="border: 1px solid black;  border-collapse: collapse;">₹'. $new_order->total_amount .'</th>
                     
                  </tr>
                  
                </table> 
                
                
                
            </body>
            </html>
            ';
        
      
        
  
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $message;
		

		$mail->send();
        
     

        
    }
    
	public function mailTest() {
//		require 'PHPMailer/vendor/autoload.php';
	//	$mail = new PHPMailer(true);


   // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
   // $mail->isSMTP();                                            //Send using SMTP
   // $mail->Host       = env('EMAIL_HOST');                     //Set the SMTP server to send through
   // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
   // $mail->Username   = env('EMAIL_USERNAME');                     //SMTP username
   // $mail->Password   = env('EMAIL_PASSWORD');                              //SMTP password
   // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
   // $mail->Port       = 465;                                    //TCP port to connect to; use 587 old 465 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
  //  $mail->setFrom('jaysatofficial@gmail.com', 'Mailer');
  //  $mail->addAddress('jaysat96@gmail.com');     //Add a recipient
 //   $mail->addAddress('jaysatmail@gmail.com');               //Name is optional
 //   $mail->addReplyTo('info@dharshinicrackersshop.com', 'Information');
 //   $mail->addCC('jaysat96@gmail.com');
 //   $mail->addBCC('jaysatofficial@gmail.com');

//    $mail->SMTPOptions = array(
//    'ssl' => array(
//        'verify_peer' => false,
//        'verify_peer_name' => false,
//        'allow_self_signed' => true
//    )
//	);
//	$mail->AuthType = 'LOGIN';
//    //Content
//    $mail->isHTML(true);                                  //Set email format to HTML
//    $mail->Subject = 'Here is the subject';
//    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//
//    $mail->send();
	}
    public function calcTotalAmount($total_amount, $paf_charges) {
        return $total_amount - $paf_charges;
    }
	
	
}

//EMAIL_HOST=88.99.242.20
//EMAIL_USERNAME=info@dharshinicrackersshop.in
//EMAIL_PASSWORD=lg~Wt516
