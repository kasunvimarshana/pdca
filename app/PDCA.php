<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PDCA extends Model
{
    //
    protected $table = "p_d_c_a_s";
    //protected $primaryKey = "id";
    //protected $keyType = 'int';
    //public $incrementing = false;
    //protected $connection = "mysql";
    //$this->setConnection("mysql");
    
    protected $fillable = array('is_visible','created_user','company_name','department_name','title','description','p_d_c_a_category_id','status_id','start_date','complete_date','piority','resource_dir');
    //protected $hidden = array();
    //protected $casts = array();
    
    //many to many
    public function userAttachments(){
        return $this->morphMany('App\UserAttachment', 'attachable');
    }
    
    //one to many
    public function pDCACompanyDepartments(){
        return $this->hasMany('App\PDCACompanyDepartment', 'p_d_c_a_id', 'id');
    }
    
    //one to many (inverse)
    public function status(){
        return $this->belongsTo('App\Status', 'status_id', 'id');
    }
    
    //one to many (inverse)
    public function pDCACategory(){
        return $this->belongsTo('App\PDCACategory', 'p_d_c_a_category_id', 'id');
    }
    
    //many to many
    public function companies(){
        return $this->belongsToMany('App\Company', 'p_d_c_a_company_departments', 'p_d_c_a_id', 'company_pk');
    }
    
    //many to many
    public function departments(){
        return $this->belongsToMany('App\Department', 'p_d_c_a_company_departments', 'p_d_c_a_id', 'department_pk');
    }
}
