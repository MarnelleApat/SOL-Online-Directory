<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title  = $this->faker->text(40);
        $price = $this->faker->numberBetween($min = 200, $max = 250);
        $venue = NULL;
        $limit = $this->faker->numberBetween($min = 10, $max = 200);

        return [
            'partner_id'     => $this->faker->randomElement([1, 2, 3, 4, 5 ,6 ,7, 8]),
            'programCode'       => 'SIBD'.$this->faker->unique()->numberBetween($min = 1000, $max = 9000),
            'title'             => $title,
            'slug'              => Str::slug($title),
            'description'       => $this->faker->text(100),
            'eventIncharge'     => $this->faker->name(),
            'activeUntil'       => $this->faker->dateTimeThisYear('+6 months'),
            'price'             => $price,
            'venue'             => $venue,
            'limit'             => $limit,
            'type'              => $this->faker->randomElement(['Physical', 'Online', 'Hybrid']),
            'email'             => $this->faker->email(),
            'totalRegistrants'  => $limit > 10 ? $limit-10 : 3,
            'status'            => $this->faker->randomElement(['Published', 'Draft', 'Approval']),
            'user_id'           => 1
        ];
    }
}
