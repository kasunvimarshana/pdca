<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PDCACompanyDepartment extends Model
{
    //
    protected $table = "p_d_c_a_company_departments";
    //protected $primaryKey = "id";
    //protected $keyType = 'int';
    //public $incrementing = false;
    //protected $connection = "mysql";
    //$this->setConnection("mysql");
    
    protected $fillable = array('is_visible','p_d_c_a_id','company_pk','department_pk');
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
    
    //one to many (inverse)
    public function pDCA(){
        return $this->belongsTo('App\PDCA', 'p_d_c_a_id', 'id');
    }
}
