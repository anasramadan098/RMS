<?php

namespace Database\Factories;

use App\Models\Supply;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ingredients = [
            ['name' => 'صدر دجاج', 'unit' => 'كيلو'],
            ['name' => 'أرز', 'unit' => 'كيلو'],
            ['name' => 'طماطم', 'unit' => 'كيلو'],
            ['name' => 'بصل', 'unit' => 'كيلو'],
            ['name' => 'زيت زيتون', 'unit' => 'لتر'],
            ['name' => 'ملح', 'unit' => 'كيلو'],
            ['name' => 'فلفل أسود', 'unit' => 'جرام'],
            ['name' => 'ثوم', 'unit' => 'كيلو'],
            ['name' => 'خس', 'unit' => 'حبة'],
            ['name' => 'جبن', 'unit' => 'كيلو'],
            ['name' => 'لحم بقري', 'unit' => 'كيلو'],
            ['name' => 'خبز', 'unit' => 'رغيف'],
            ['name' => 'بيض', 'unit' => 'حبة'],
            ['name' => 'حليب', 'unit' => 'لتر'],
            ['name' => 'دقيق', 'unit' => 'كيلو'],
        ];

        $ingredient = fake()->randomElement($ingredients);

        return [
            'name' => $ingredient['name'],
            'description' => fake()->sentence(8),
            'unit' => $ingredient['unit'],
            'price_per_unit' => fake()->randomFloat(2, 1, 50),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'min_stock_level' => fake()->numberBetween(5, 20),
            'image' => fake()->imageUrl(300, 300, 'food'),
            'is_active' => fake()->boolean(95), // 95% chance of being active
            'supplier_id' => Supply::all()->random()->id,
        ];
    }
}
