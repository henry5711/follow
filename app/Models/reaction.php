<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;
use TypeReaction;

class reaction extends CrudModel
{
    protected $guarded = ['id'];
    protected $table = 'reaction';
    protected $fillable = ['fk_type_rea', 'fk_post_id', 'usu_id', 'usu_name'];

    public function type_reaction()
    {
        return $this->hasOne(TypeReaction::class,'fk_type_rea');
    }
}
