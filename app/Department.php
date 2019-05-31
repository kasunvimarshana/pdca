<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    protected $table = "departments";
    protected $primaryKey = "name";
    protected $keyType = 'string';
    //public $incrementing = false;
    //protected $connection = "mysql";
    //$this->setConnection("mysql");
    
    protected $fillable = array('is_visible', 'name');
    //protected $hidden = array();
    //protected $casts = array();
    
    //one to many
    public function companyDepartments(){
        return $this->hasMany('App\CompanyDepartment', 'department_pk', 'name');
    }
    
    //one to many
    public function pDCAs(){
        return $this->hasMany('App\PDCA', 'department_name', 'name');
    }
    
    //one to many
    public function pDCACompanyDepartments(){
        return $this->hasMany('App\PDCACompanyDepartment', 'department_pk', 'name');
    }
}
