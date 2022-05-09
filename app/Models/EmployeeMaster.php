<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeMaster extends Model
{
    protected $connection = 'hrms';
    protected $table = 'emp_masters';

    /*public function submit_form_status()
    {
        return $this->hasOne(EmployeeSubmit::class,'empid','Ecode');
    }*/
}
