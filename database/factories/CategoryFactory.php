<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        // $name  = $this->faker->randomElements(['Bible', 'Family', 'Mental Wellness', 'Mission', 'Stewardship', 'Ministry & Leadeship']);
        $name  = $this->faker->text(10);

        return [
            'name'          => $name,
            'slug'          => Str::slug($name),
            'description'   => $this->faker->text(100),
        ];
    }
}
