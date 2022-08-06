<?php


namespace App\Http\Controllers\AppControllers\Methods;

use App\Models\AppModels\StaffsModel;
use Illuminate\Http\Request;

class StaffsMethods
{


    public function methodGetStaffs() {
        return StaffsModel::all();
    }
	
	public function methodCreateNewStaff(Request $request) {
		return StaffsModel::create($request->all());
	}
	
	public function methodUpdateStaff(Request $request){
	    return StaffsModel::where('id',$request->id)->update(json_decode(json_encode($request->data), true));
	}
	
	public function methodLogin(Request $request){
	   $staff_model = StaffsModel::where('staff_name', $request->staff_name)->first();
		$login_result = [];
		if($staff_model) {
			if ($request->staff_password == $staff_model->staff_password) {
			    
			   
    				$login_result['is_login_success'] = true;
    				$login_result['error'] = null;
    				$login_result['id'] = $staff_model->id;
    				$login_result['designation'] = $staff_model->designation;
    			
				
			} else {
				$login_result['is_login_success'] = false;
				$login_result['error'] = "Password Incorrect";
			}
		} else {
			$login_result['is_login_success'] = false;
			$login_result['error'] = "Username not Exists";
		}
		
		
        return $login_result;
	    
	}

}