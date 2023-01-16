<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class post extends CrudModel
{
    protected $guarded = ['id'];
    protected $table= 'post';
    protected $fillable=['title','user_id','fecha','status','type','price'];

    public function user()
    {
        return $this->hasMany(User::class,'user_id');
    }

    public function comments(){
        return $this->hasMany(comments::class,'fk_post_id','id');
    }

    public function reaction(){
        return $this->hasMany(reaction::class,'fk_post_id','id');
    }

    public function images(){
        return $this->hasMany(images::class,'id_post');
    }

    public function commentsLimit(){
        return $this->hasMany(comments::class,'fk_post_id','id')->orderBy('id','desc')->limit(5);
    }

}
