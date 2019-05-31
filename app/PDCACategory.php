<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PDCACategory extends Model
{
    //
    protected $table = "p_d_c_a_categories";
    //protected $primaryKey = "id";
    //protected $keyType = 'int';
    //public $incrementing = false;
    //protected $connection = "mysql";
    //$this->setConnection("mysql");
    
    //protected $fillable = array();
    //protected $hidden = array();
    //protected $casts = array();
    
    //one to many
    public function pDCAs(){
        return $this->hasMany('App\PDCA', 'p_d_c_a_category_id', 'id');
    }
}
