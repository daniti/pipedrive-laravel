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
        $key = env('TOKEN_PASSWORD') . $this->salt;
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

        $decrypted = openssl_decrypt(base64_decode($this->body), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

        return json_decode($decrypted);
    }

}
