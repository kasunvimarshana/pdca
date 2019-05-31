<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PDCAInfo extends Model
{
    //
    protected $table = "p_d_c_a_infos";
    //protected $primaryKey = "id";
    //protected $keyType = 'int';
    //public $incrementing = false;
    //protected $connection = "mysql";
    //$this->setConnection("mysql");
    
    protected $fillable = array('is_visible','p_d_c_a_id','description','created_user');
    //protected $hidden = array();
    //protected $casts = array();
    
    //many to many
    public function userAttachments(){
        return $this->morphMany('App\UserAttachment', 'attachable');
    }
    
    //one to many (inverse)
    public function pDCA(){
        return $this->belongsTo('App\PDCA', 'p_d_c_a_id', 'id');
    }
}
