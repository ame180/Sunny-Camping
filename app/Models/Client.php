<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends BaseModel
{
    use HasFactory;
    protected $guarded = [];

    public function clientItems() {
        return $this->hasMany(ClientItem::class);
    }
}
