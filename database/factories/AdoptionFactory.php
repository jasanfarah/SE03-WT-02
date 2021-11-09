<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdoptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'        => $this->faker->firstName,
            'description' => $this->faker->paragraph,
            'image_path'  => "imgs/demo/" . $this->faker->numberBetween(1, 12) . ".jpg"
        ];
    }
}
