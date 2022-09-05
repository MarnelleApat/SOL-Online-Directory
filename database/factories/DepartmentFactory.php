<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name  = $this->faker->text(20);

        return [
            'name'          => $name,
            'slug'          => Str::slug($name),
            'description'   => $this->faker->text(100),
            'websiteUrl'    => $this->faker->url()
        ];
    }
}
