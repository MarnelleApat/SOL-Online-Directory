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
        $schedule = '[{"startDate":"2022-03-09", "startTime":"08:00", "endTime": "09:00"}]';
        $venue = '{"location": "4980 Bechtelar Shoals Willmsville", "city": "UT", "country": "USA", "postalCode": "6014"}';
        $limit = $this->faker->numberBetween($min = 10, $max = 200);

        return [
            'department_id'     => $this->faker->randomElement([1, 2, 3, 4, 5 ,6 ,7, 8]),
            'tenant_id'         => 2,
            'programCode'       => 'SIBD'.$this->faker->unique()->numberBetween($min = 1000, $max = 9000),
            'title'             => $title,
            'slug'              => Str::slug($title),
            'description'       => $this->faker->text(100),
            'checkHandler'      => $this->faker->name(),
            'eventIncharge'     => $this->faker->name(),
            'schedule'          => $schedule,
            'activeUntil'       => $this->faker->dateTimeThisYear('+6 months'),
            'price'             => $price,
            'venue'             => $venue,
            'limit'             => $limit,
            'email'             => $this->faker->email(),
            'totalRegistrants'  => $limit > 10 ? $limit-10 : 3,
            'user_id'           => 1
        ];
    }
}
