<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class PipedriveTokenIO implements \Devio\Pipedrive\PipedriveTokenStorage
{
    protected $pipedrive_token;

    public function __construct()
    {
        $this->pipedrive_token = PipedriveTokenModel::firstOrNew(['user_id' => Auth::user()->id]);
    }

    public function setToken(\Devio\Pipedrive\PipedriveToken $token)
    {
        $this->pipedrive_token->store($token);
    }

    public function getToken()
    {
        return $this->pipedrive_token->body();
    }
}
