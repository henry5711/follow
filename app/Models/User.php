<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model

    {

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $connection = 'READ_ONLY';
    protected $fillable = [
        'id',
        'id_fk_account',
        'fk_id_type', //rol de usuaro
        'fk_id_category_type', //tipo de usuario
        'nacionality',
        'full_name',
        'email',
        'email_verified_at',
        'type',
        'photo_url',
        'n_socio',
        'genero',
        'document',
        'act',
        'golf_player',
        'birthdate',
        'id_token_gmail',
        'id_token_facebook',
        'id_token_firebase',
        'id_token_apple',
        'descripcion',
        'api_token',
        'phone_code',
        'phone',
        'act_movil',
        'act_email',
        'code_sms_value',
        'parentesco',
        'fk_clase',
        'economic_status',
        'msj_user',
        'fondo_img',
        'nick_name_user',
        'adress_principal',
        'act_profile',
        'register_coor',
        'create_at',
        'update_at'
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];

}
