<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class seguidores extends CrudModel
{
    protected $guarded = ['id'];
    protected $table= 'seguidores';
    protected $fillable=['user_id','follow_id'];
}
