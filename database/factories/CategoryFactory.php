<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        $categories = [
            [
                'ar' => 'الأطباق الرئيسية',
                'en' => 'Main Dishes',
                'desc_ar' => 'أطباق رئيسية شهية ومتنوعة',
                'desc_en' => 'Delicious and varied main dishes',
                'type' => 'food'
            ],
            [
                'ar' => 'المقبلات',
                'en' => 'Appetizers',
                'desc_ar' => 'مقبلات طازجة ولذيذة',
                'desc_en' => 'Fresh and delicious appetizers',
                'type' => 'food'
            ],
            [
                'ar' => 'الحلويات',
                'en' => 'Desserts',
                'desc_ar' => 'حلويات شرقية وغربية',
                'desc_en' => 'Eastern and Western desserts',
                'type' => 'food'
            ],
            [
                'ar' => 'المشروبات',
                'en' => 'Beverages',
                'desc_ar' => 'مشروبات باردة وساخنة',
                'desc_en' => 'Hot and cold beverages',
                'type' => 'drink'
            ],
            [
                'ar' => 'السلطات',
                'en' => 'Salads',
                'desc_ar' => 'سلطات طازجة وصحية',
                'desc_en' => 'Fresh and healthy salads',
                'type' => 'food'
            ],
            [
                'ar' => 'الشوربات',
                'en' => 'Soups',
                'desc_ar' => 'شوربات دافئة ومغذية',
                'desc_en' => 'Warm and nutritious soups',
                'type' => 'food'
            ],
            [
                'ar' => 'المعجنات',
                'en' => 'Pastries',
                'desc_ar' => 'معجنات طازجة ومخبوزة',
                'desc_en' => 'Fresh and baked pastries',
                'type' => 'food'
            ],
            [
                'ar' => 'الوجبات السريعة',
                'en' => 'Fast Food',
                'desc_ar' => 'وجبات سريعة ولذيذة',
                'desc_en' => 'Quick and delicious fast food',
                'type' => 'food'
            ],
        ];

        $selectedCategory = fake()->randomElement($categories);

        return [
            'name_ar' => $selectedCategory['ar'],
            'name_en' => $selectedCategory['en'],
            'description_ar' => $selectedCategory['desc_ar'],
            'description_en' => $selectedCategory['desc_en'],
            'image' => fake()->imageUrl(400, 300, 'food'),
            'is_active' => fake()->boolean(90), // 90% chance of being active
            'type' => $selectedCategory['type'],
        ];
    }
}
