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

    protected function token_salt()
    {
        return password_hash(env('TOKEN_PASSWORD'), PASSWORD_BCRYPT, ['cost' => 12]);
    }

    protected function encrypt_token($token, $salt)
    {
        $body = json_encode($token);

        $password = env('TOKEN_PASSWORD');

        $key = $password . $salt;
        echo "Key:" . $key . "\n";

        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

        return base64_encode(openssl_encrypt($body, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv));
    }

    public function storeToken($token)
    {
        $pipedrive_token = PipedriveToken::firstOrNew(['user_id' => $this->id]);

        $salt = $this->token_salt();

        $pipedrive_token->user_id = $this->id;
        $pipedrive_token->body = $this->encrypt_token($token, $salt);
        $pipedrive_token->salt = $salt;

        $pipedrive_token->save();
    }

    public function pipedrive_token()
    {
        return $this->hasOne(PipedriveToken::class);
    }
}
