<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'pipedrive_user_id', 'pipedrive_company_id'
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
        $pipedrive_token = PipedriveToken::firstOrNew(['user_id' => $this->id]);
        $pipedrive_token->store($token);

    }

    public function pipedrive_token()
    {
        return $this->hasOne(PipedriveToken::class);
    }
}
