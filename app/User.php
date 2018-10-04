<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'pipedrive_user_id', 'pipedrive_company_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function storeToken($token)
    {
        $pipedrive_token_model = PipedriveTokenModel::firstOrNew(['user_id' => $this->id]);

        $pipedrive_token = new \Devio\Pipedrive\PipedriveToken([
            'accessToken' => $token['access_token'],
            'refreshToken' => $token['refresh_token'],
            'expiresAt' => time() + $token['expires_in'],
        ]);

        $pipedrive_token_model->store($pipedrive_token);
    }

    public function pipedrive_token()
    {
        return $this->hasOne(PipedriveTokenModel::class);
    }
}
