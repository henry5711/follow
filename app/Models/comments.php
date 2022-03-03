<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class comments extends CrudModel
{
    protected $guarded = ['id'];
    protected $table= 'coments';
    protected $fillable=['user_id','user_name','contend','fk_post_id','sta'];
}