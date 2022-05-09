<?php

namespace App\Http\Controllers\ckyc;

use Illuminate\Http\Request;
use App\Models\{Employee,Branch,LoginUser};

class LoginController extends Controller {
    public function index(Request $request)	{

        if($request->session()->has('employee_id')) {
            return redirect()->route('home'); 
        } else {
            return view('login');
        }
    }
    public function login(Request $request) {
		$this->validate($request,['employee_id' => 'required|numeric', 'password' => 'required' ]);
		if(request('employee_id')==6160 || request('employee_id')==5580 || request('employee_id') == 5180 || request('employee_id')==4996 || request('employee_id')==5858 || request('employee_id')==5203 || request('employee_id')==2594 || request('employee_id') == 9015 || request('employee_id') == 5249 || request('employee_id') == 2984)
		{
			$emparray = Employee::where('ECode',request('employee_id'))->select('Name','Pwd')->first()->toArray();
			//$emparray = LoginUser::where('ecode',request('employee_id'))->select('name','pwd')->first()->toArray();
			if (!empty($emparray) &&($emparray['Pwd']==request('password'))) {		
				session(['employee_id' => request('employee_id')]);
				session(['employee_name' => $emparray['Name']]);
				return redirect()->route('emp_summary');           
			} else {        
				return redirect('login')->with('wrongpwd',"Incorrect Employee Code or Password");
			} 	
		}
		else
		{
			return redirect('login')->with('wrongpwd',"Operation cannot be done at this time");
		}
			       
    }
    public  function logout(Request $request){
        $request->session()->flush();
        return redirect('login')->with('logout',"Successfully Logout");
    }
}

