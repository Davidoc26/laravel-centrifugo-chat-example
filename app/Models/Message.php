<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Message extends Model
{
    use HasFactory, HasEagerLimit;

    protected $fillable = ['receiver_id', 'sender_id', 'body'];

    public function getSender(): User
    {
        return $this->belongsTo(User::class, 'sender_id')->first();
    }

    public function getReceiver(): User
    {
        return $this->belongsTo(User::class, 'receiver_id')->first();
    }
}
