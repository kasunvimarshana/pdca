<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class UserAttachment extends Model
{
    //
    protected $table = "user_attachments";
    //protected $primaryKey = "id";
    //protected $keyType = 'int';
    //public $incrementing = false;
    //protected $connection = "mysql";
    //$this->setConnection("mysql");
    
    protected $fillable = array('is_visible','attached_by','file_original_name','attachable_type','attachable_id','file_type','link_url');
    //protected $hidden = array();
    //protected $casts = array();
    
    //one to many (inverse)
    public function attachable(){
        return $this->morphTo('attachable', 'attachable_type', 'attachable_id');
    }
    
    //one to many (inverse)
    public function attachedBy(){
        $user = new User();
        $user->mail = $this->attached_by;
        $user->getUser();
        $user->thumbnailphoto = null;
        return $user;
    }
    
}
