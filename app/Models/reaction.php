<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class reaction extends CrudModel
{
    protected $guarded = ['id'];
    protected $table = 'reaction';
    protected $fillable = ['fk_type_rea','fk_post_id','usu_id','usu_name'];
}