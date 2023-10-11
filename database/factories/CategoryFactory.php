<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word(2);
        return [
            'name' => $name,
            'slug' => Str::slug($name).rand(0,1000),
            'description' => $this->faker->sentence(15),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
