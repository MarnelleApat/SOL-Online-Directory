<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fname = $this->faker->firstName();
        $lname = $this->faker->lastName();

        $get_roles = Role::pluck('id')->all();

        return [
            'firstname'         => $fname,
            'lastname'          => $lname,
            'niceName'          => $fname.' '.$lname,
            'username'          => $this->faker->unique()->username,
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => '$2y$10$Ry6lLewUNBp6CRMvMQIehO3vLkSXVzpEozwvdI7Y/oV0T/Vtwg/k.', // 1234
            'remember_token'    => Str::random(10),
            'is_admin'          => $this->faker->randomElement([1, 0]),
            'is_active'          => $this->faker->randomElement([1, 0]),
            'role_id'           => $this->faker->randomElement($get_roles),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
