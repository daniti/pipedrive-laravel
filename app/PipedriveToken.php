<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PipedriveToken extends Model
{
    protected $table = 'pipedrive_tokens';

    protected $fillable = [
        'user_id', 'body'
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
        $this->body = $this->encrypt_token($token);

        $this->save();
    }

    protected function decrypt_token()
    {
        return decrypt($this->body);
    }

    protected function encrypt_token($token)
    {
        $body = json_encode($token);

        return encrypt($body);
    }

}
