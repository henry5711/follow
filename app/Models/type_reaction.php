<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class type_reaction extends CrudModel
{
    protected $guarded = ['id'];
    protected $table = 'type_reaction';
    protected $fillable= ['name','icon'];
}
