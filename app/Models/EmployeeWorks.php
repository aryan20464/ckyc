<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeWorks extends Model
{
    protected $connection = 'hrms';
    protected $table = 'emp_cur_works';

    /*public function submit_form_status()
    {
        return $this->hasOne(EmployeeSubmit::class,'empid','Ecode');
    }*/
}
