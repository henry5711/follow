<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class seguidores extends CrudModel
{
    protected $guarded = ['id'];
    protected $table= 'seguidores';
    protected $fillable=['user_id','user_name','follow_id','follow_name'];
}