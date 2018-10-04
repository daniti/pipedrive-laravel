<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PipedriveTokenModel extends Model
{
    protected $table = 'pipedrive_tokens';

    protected $fillable = [
        'user_id', 'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function body()
    {
        return unserialize($this->body);
    }

    public function store($token)
    {
        $this->body = serialize($token);

        $this->save();
    }
}
