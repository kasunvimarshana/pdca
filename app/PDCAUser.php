<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PDCAUser extends Model
{
    //
    protected $table = "p_d_c_a_users";
    //protected $primaryKey = "id";
    //protected $keyType = 'int';
    //public $incrementing = false;
    //protected $connection = "mysql";
    //$this->setConnection("mysql");
    
    protected $fillable = array('is_visible','p_d_c_a_id','own_user','company_name','department_name');
    //protected $hidden = array();
    //protected $casts = array();
    
    //one to many (inverse)
    public function company(){
        return $this->belongsTo('App\Company', 'company_name', 'name');
    }
    
    //one to many (inverse)
    public function department(){
        return $this->belongsTo('App\Department', 'department_name', 'name');
    }
    
    //one to many (inverse)
    public function pDCA(){
        return $this->belongsTo('App\PDCA', 'p_d_c_a_id', 'id');
    }
}
