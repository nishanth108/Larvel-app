<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PropertyTypeFactory extends Factory
{
    protected $model = \App\Models\PropertyType::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $icons = ['fa-user', 'fa-star', 'fa-heart', 'fa-gear', 'fa-check'];
        return [
            'type_name' => fake()->name(),
            'type_icon' => fake()->randomElement($icons)
        ];
    }
}
