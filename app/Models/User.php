<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasEagerLimit;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id', 'id');
    }

    /**
     * @param int $user_id
     * @param int $limit
     * @param string $orderBy
     * @return Collection
     */
    public function getMessagesWith(int $user_id, int $limit = 0, string $orderBy = 'ASC'): Collection
    {
        $messages = $this->messages()
            ->where(fn($q) => $q
                ->where('receiver_id', $user_id)
                ->where('sender_id', $this->id))
            ->orWhere(fn($q) => $q
                ->where('receiver_id', $this->id)
                ->where('sender_id', $user_id))
            ->orderBy('created_at',$orderBy);
        if ($limit) {
            $messages->limit($limit);
        }

        return $messages->get();
    }

}
