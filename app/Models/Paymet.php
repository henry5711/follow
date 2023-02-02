<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymet extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'user_id', 'code', 'pay'];

    public function scopeFiltro($query, $request)
    {
        return $query
            ->when($request->post_id, function ($query, $post_id) {
                return $query->where('post_id', $post_id);
            })
            ->when($request->user_id, function ($query, $user_id) {
                return $query->where('user_id', $user_id);
            })
            ->when($request->code, function ($query, $code) {
                return $query->where('code', $code);
            })
            ->when($request->pay, function ($query, $pay) {
                return $query->where('uay', $pay);
            });
    }
}
