<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class post extends CrudModel
{
    protected $guarded = ['id'];
    protected $table= 'post';
    protected $fillable=['title','user_id','user_name','contenido','fecha','status'];
}