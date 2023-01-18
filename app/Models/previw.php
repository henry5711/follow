<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class previw extends Model
{
    use HasFactory;
    protected $fillable=['url_previw','post_id','active'];

}
