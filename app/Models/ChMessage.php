<?php

namespace App\Models;

use App\Services\PlayFairService;
use Illuminate\Database\Eloquent\Model;
use Chatify\Traits\UUID;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ChMessage extends Model
{
    use UUID;

    public function setBodyAttribute($value)
    {
        $service = new PlayFairService();
        $this->attributes['body'] = $service->playfairEncrypt($value, $this->getKey());
    }

    public function getBodyAttribute()
    {
        return (new PlayFairService())
            ->playfairDecrypt($this->attributes['body'], $this->getKey());
    }

    public function getKey()
    {
        return "chatappencrypt";
    }
}
