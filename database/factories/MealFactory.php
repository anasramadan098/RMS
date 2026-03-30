<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $meals = [
            [
                'ar' => 'كباب مشوي',
                'en' => 'Grilled Kebab',
                'desc_ar' => 'كباب لحم مشوي على الفحم مع الخضار',
                'desc_en' => 'Grilled meat kebab with vegetables on charcoal'
            ],
            [
                'ar' => 'دجاج مشوي',
                'en' => 'Grilled Chicken',
                'desc_ar' => 'دجاج مشوي بالأعشاب والتوابل',
                'desc_en' => 'Grilled chicken with herbs and spices'
            ],
            [
                'ar' => 'أرز بالخضار',
                'en' => 'Vegetable Rice',
                'desc_ar' => 'أرز مطبوخ مع خليط من الخضار الطازجة',
                'desc_en' => 'Rice cooked with fresh mixed vegetables'
            ],
            [
                'ar' => 'سلطة خضراء',
                'en' => 'Green Salad',
                'desc_ar' => 'سلطة طازجة من الخضار الورقية والطماطم',
                'desc_en' => 'Fresh salad with leafy greens and tomatoes'
            ],
            [
                'ar' => 'شوربة عدس',
                'en' => 'Lentil Soup',
                'desc_ar' => 'شوربة عدس دافئة ومغذية',
                'desc_en' => 'Warm and nutritious lentil soup'
            ],
            [
                'ar' => 'فتة باللحم',
                'en' => 'Meat Fatteh',
                'desc_ar' => 'فتة تقليدية باللحم والأرز',
                'desc_en' => 'Traditional fatteh with meat and rice'
            ],
            [
                'ar' => 'مندي دجاج',
                'en' => 'Chicken Mandi',
                'desc_ar' => 'دجاج مندي بالأرز البسمتي والتوابل',
                'desc_en' => 'Chicken mandi with basmati rice and spices'
            ],
            [
                'ar' => 'برياني لحم',
                'en' => 'Meat Biryani',
                'desc_ar' => 'برياني لحم بالأرز المعطر والزعفران',
                'desc_en' => 'Meat biryani with aromatic rice and saffron'
            ],
            [
                'ar' => 'سمك مقلي',
                'en' => 'Fried Fish',
                'desc_ar' => 'سمك طازج مقلي مع الليمون',
                'desc_en' => 'Fresh fried fish with lemon'
            ],
            [
                'ar' => 'كفتة بالطحينة',
                'en' => 'Kofta with Tahini',
                'desc_ar' => 'كفتة لحم مع صلصة الطحينة',
                'desc_en' => 'Meat kofta with tahini sauce'
            ],
            [
                'ar' => 'ملوخية بالدجاج',
                'en' => 'Molokhia with Chicken',
                'desc_ar' => 'ملوخية خضراء مع قطع الدجاج',
                'desc_en' => 'Green molokhia with chicken pieces'
            ],
            [
                'ar' => 'محشي ورق عنب',
                'en' => 'Stuffed Grape Leaves',
                'desc_ar' => 'ورق عنب محشي بالأرز واللحم',
                'desc_en' => 'Grape leaves stuffed with rice and meat'
            ],
            [
                'ar' => 'كنافة نابلسية',
                'en' => 'Nablus Kunafa',
                'desc_ar' => 'حلوى كنافة تقليدية بالجبن',
                'desc_en' => 'Traditional cheese kunafa dessert'
            ],
            [
                'ar' => 'بقلاوة',
                'en' => 'Baklava',
                'desc_ar' => 'حلوى بقلاوة بالمكسرات والعسل',
                'desc_en' => 'Baklava pastry with nuts and honey'
            ],
            [
                'ar' => 'عصير برتقال طازج',
                'en' => 'Fresh Orange Juice',
                'desc_ar' => 'عصير برتقال طبيعي طازج',
                'desc_en' => 'Fresh natural orange juice'
            ],
        ];

        $selectedMeal = fake()->randomElement($meals);

        return [
            'name_ar' => $selectedMeal['ar'],
            'name_en' => $selectedMeal['en'],
            'description_ar' => $selectedMeal['desc_ar'],
            'description_en' => $selectedMeal['desc_en'],
            'price' => fake()->randomFloat(2, 10, 100),
            'preparation_time' => fake()->numberBetween(10, 60),
            'image' => fake()->imageUrl(500, 400, 'food'),
            'is_available' => fake()->boolean(85), // 85% chance of being available
            'is_active' => fake()->boolean(95), // 95% chance of being active
            'category_id' => Category::factory(),
        ];
    }
}
