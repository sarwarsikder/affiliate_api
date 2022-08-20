<?php

namespace Database\Factories;

use App\Models\ShopCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'shop_name' => $this->faker->word(),
            'shop_logo' => $this->faker->image('public/storage/images', 150, 150, null, false),
            'shop_description' => $this->faker->text(),
            'shop_benefits' => $this->faker->bothify(),
            'shop_category_id' => ShopCategory::factory()
        ];
    }
}
