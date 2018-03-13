<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PipedriveToken extends Model
{
    protected $table = 'pipedrive_tokens';

    protected $fillable = [
        'user_id', 'body', 'salt'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function body()
    {
        return json_decode($this->decrypt_token());
    }

    public function store($token)
    {
        $salt = $this->token_salt();

        $this->body = $this->encrypt_token($token, $salt);
        $this->salt = $salt;

        $this->save();
    }

    protected function token_salt()
    {
        return password_hash(env('TOKEN_PASSWORD'), PASSWORD_BCRYPT, ['cost' => 12]);
    }

    protected function decrypt_token()
    {
        $key = env('TOKEN_PASSWORD') . $this->salt;
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

        return openssl_decrypt(base64_decode($this->body), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
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

}
