<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Chatify\Traits\UUID;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ChMessage extends Model
{
    use UUID;

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = encrypt($value);
    }

    public function getBodyAttribute()
    {
        return decrypt($this->attributes['body']);
    }
}
