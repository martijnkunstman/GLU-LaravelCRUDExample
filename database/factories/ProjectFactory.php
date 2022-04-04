<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'desc' => $this->faker->sentence(),
            'date' => $this->faker->date(),
            'url' => $this->faker->url(),
            'image_name' => $this->faker->imageUrl(640, 480, 'animals', true),
            'image_path' => "image_upload",
            'active' => $this->faker->boolean(),
            'cat_id' => 0,
        ];
    }
}
