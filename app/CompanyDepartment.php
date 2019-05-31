<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDepartment extends Model
{
    //
    protected $table = "company_departments";
    //protected $primaryKey = "id";
    //protected $keyType = 'int';
    //public $incrementing = false;
    //protected $connection = "mysql";
    //$this->setConnection("mysql");
    
    //protected $fillable = array();
    //protected $hidden = array();
    //protected $casts = array();
    
    //one to many (inverse)
    public function company(){
        return $this->belongsTo('App\Company', 'company_pk', 'name');
    }
    
    //one to many (inverse)
    public function department(){
        return $this->belongsTo('App\Department', 'department_pk', 'name');
    }
}
