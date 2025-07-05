<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class; // atau model dari config('laravel-tournaments.user.model')

    public function definition(): array
    {
        return [
            'name'       => $this->faker->userName,
            'email'      => $this->faker->unique()->safeEmail,
            'password'   => bcrypt('password'), // atau: Hash::make('password')
            'firstname'  => $this->faker->firstName,
            'lastname'   => $this->faker->lastName,
            'birthDate'  => $this->faker->date('Y-m-d', '2020-12-30'),
            'gender'     => $this->faker->randomElement(['M', 'F']),
        ];
    }

}
