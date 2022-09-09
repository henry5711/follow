<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class images extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table= 'images';
    protected $fillable=['id_post','contenido'];

    public function post(){
        return $this->belongsTo(post::class);
    }

}
