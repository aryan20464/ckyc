<?php

namespace App\Http\Middleware;

use App\Models\EmployeeWorks;
use Closure;

class GlobalConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('employee_id') && ($request->session()->get('employee_id')==6160 || $request->session()->get('employee_id')==5580) || $request->session()->get('employee_id')==5180 || $request->session()->get('employee_id')==4996 ||$request->session()->get('employee_id')==5858) {
            config(['bcode'=>EmployeeWorks::where('emp_id',$request->session()->get('employee_id'))->pluck('office_code')[0]]);
            if(EmployeeWorks::where('emp_id',$request->session()->get('employee_id'))->pluck('office_code')[0]==9909)
            {
                config(['Admin'=>'Yes']);
            }			
		}
		return $next($request);
    }
}
