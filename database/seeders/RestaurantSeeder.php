<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\Supply;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء الفئات
        $categories = Category::factory(6)->create();

        // Supply
        $supply = Supply::factory(3)->create();

        // إنشاء المكونات
        $ingredients = Ingredient::factory(15)->create();

        // إنشاء الوجبات وربطها بالفئات الموجودة
        $meals = Meal::factory(20)->create([
            'category_id' => $categories->random()->id,
        ]);

        // ربط الوجبات بالمكونات (علاقة many-to-many)
        foreach ($meals as $meal) {
            // اختيار عدد عشوائي من المكونات لكل وجبة (2-5 مكونات)
            $randomIngredients = $ingredients->random(rand(2, 5));

            foreach ($randomIngredients as $ingredient) {
                $meal->ingredients()->attach($ingredient->id, [
                    'quantity' => fake()->randomFloat(2, 0.1, 5), // كمية عشوائية
                    'notes' => fake()->optional()->sentence(3), // ملاحظات اختيارية
                ]);
            }
        }
    }
}
