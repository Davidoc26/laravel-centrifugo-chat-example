<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $sender = User::all()->random();
        $receiver = User::all()->random();
        while ($sender->id === $receiver->id) {
            $receiver = User::all()->random();
        }

        return [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'body' => $this->faker->realText($this->faker->numberBetween(10, 20))
        ];
    }
}
