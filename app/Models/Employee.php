<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EmployeeSubmit;

class Employee extends Model
{
    protected $connection = 'Employees';
    protected $table = 'employees';

    /*public function submit_form_status()
    {
        return $this->hasOne(EmployeeSubmit::class,'empid','Ecode');
    }*/
}
