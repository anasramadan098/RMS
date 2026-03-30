<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Meal;
use App\Models\MealSize;
use App\Models\MealExtra;

class MealSizesAndExtrasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء فئات تجريبية
        $categories = [
            [
                'name_ar' => 'بيتزا',
                'name_en' => 'Pizza',
                'description_ar' => 'بيتزا لذيذة',
                'description_en' => 'Delicious pizzas',
                'is_active' => true,
                'type' => 'food'
            ],
            [
                'name_ar' => 'برجر',
                'name_en' => 'Burgers',
                'description_ar' => 'برجر شهي',
                'description_en' => 'Tasty burgers',
                'is_active' => true,
                'type' => 'food'
            ],
            [
                'name_ar' => 'مشروبات',
                'name_en' => 'Drinks',
                'description_ar' => 'مشروبات منعشة',
                'description_en' => 'Refreshing drinks',
                'is_active' => true,
                'type' => 'drink'
            ]
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);

            if ($category->name_ar === 'بيتزا') {
                // إنشاء وجبات بيتزا
                $pizzas = [
                    [
                        'name_ar' => 'بيتزا مارجريتا',
                        'name_en' => 'Margherita Pizza',
                        'description_ar' => 'بيتزا كلاسيكية بالطماطم والجبن والريحان',
                        'description_en' => 'Classic pizza with tomato, cheese and basil',
                        'price' => 45.00,
                        'category_id' => $category->id,
                        'is_active' => true,
                        'is_available' => true,
                        'preparation_time' => 15,
                        'image' => 'https://via.placeholder.com/300x200?text=Margherita+Pizza'
                    ],
                    [
                        'name_ar' => 'بيتزا بيبروني',
                        'name_en' => 'Pepperoni Pizza',
                        'description_ar' => 'بيتزا بالبيبروني والجبن',
                        'description_en' => 'Pizza with pepperoni and cheese',
                        'price' => 55.00,
                        'category_id' => $category->id,
                        'is_active' => true,
                        'is_available' => true,
                        'preparation_time' => 18,
                        'image' => 'https://via.placeholder.com/300x200?text=Pepperoni+Pizza'
                    ]
                ];

                foreach ($pizzas as $pizzaData) {
                    $pizza = Meal::create($pizzaData);
                    $this->addSizesAndExtras($pizza);
                }
            }

            if ($category->name_ar === 'برجر') {
                // إنشاء وجبات برجر
                $burgers = [
                    [
                        'name_ar' => 'برجر كلاسيك',
                        'name_en' => 'Classic Burger',
                        'description_ar' => 'برجر لحم بقري مع الخس والطماطم',
                        'description_en' => 'Beef burger with lettuce and tomato',
                        'price' => 35.00,
                        'category_id' => $category->id,
                        'is_active' => true,
                        'is_available' => true,
                        'preparation_time' => 12,
                        'image' => 'https://via.placeholder.com/300x200?text=Classic+Burger'
                    ],
                    [
                        'name_ar' => 'برجر دجاج',
                        'name_en' => 'Chicken Burger',
                        'description_ar' => 'برجر دجاج مشوي مع الصوص الخاص',
                        'description_en' => 'Grilled chicken burger with special sauce',
                        'price' => 30.00,
                        'category_id' => $category->id,
                        'is_active' => true,
                        'is_available' => true,
                        'preparation_time' => 10,
                        'image' => 'https://via.placeholder.com/300x200?text=Chicken+Burger'
                    ]
                ];

                foreach ($burgers as $burgerData) {
                    $burger = Meal::create($burgerData);
                    $this->addSizesAndExtras($burger);
                }
            }

            if ($category->name_ar === 'مشروبات') {
                // إنشاء مشروبات
                $drinks = [
                    [
                        'name_ar' => 'كوكا كولا',
                        'name_en' => 'Coca Cola',
                        'description_ar' => 'مشروب غازي منعش',
                        'description_en' => 'Refreshing soft drink',
                        'price' => 8.00,
                        'category_id' => $category->id,
                        'is_active' => true,
                        'is_available' => true,
                        'preparation_time' => 2,
                        'image' => 'https://via.placeholder.com/300x200?text=Coca+Cola'
                    ],
                    [
                        'name_ar' => 'عصير برتقال طازج',
                        'name_en' => 'Fresh Orange Juice',
                        'description_ar' => 'عصير برتقال طبيعي 100%',
                        'description_en' => '100% natural orange juice',
                        'price' => 12.00,
                        'category_id' => $category->id,
                        'is_active' => true,
                        'is_available' => true,
                        'preparation_time' => 5,
                        'image' => 'https://via.placeholder.com/300x200?text=Orange+Juice'
                    ]
                ];

                foreach ($drinks as $drinkData) {
                    $drink = Meal::create($drinkData);
                    $this->addDrinkSizes($drink);
                }
            }
        }
    }

    /**
     * إضافة أحجام وإضافات للوجبات الرئيسية
     */
    private function addSizesAndExtras(Meal $meal)
    {
        // إضافة الأحجام
        $sizes = [
            [
                'name_ar' => 'صغير',
                'name_en' => 'Small',
                'price' => $meal->price - 10,
                'additional_price' => -10,
                'is_default' => false,
                'sort_order' => 1
            ],
            [
                'name_ar' => 'متوسط',
                'name_en' => 'Medium',
                'price' => $meal->price,
                'additional_price' => 0,
                'is_default' => true,
                'sort_order' => 2
            ],
            [
                'name_ar' => 'كبير',
                'name_en' => 'Large',
                'price' => $meal->price + 15,
                'additional_price' => 15,
                'is_default' => false,
                'sort_order' => 3
            ]
        ];

        foreach ($sizes as $sizeData) {
            MealSize::create(array_merge($sizeData, ['meal_id' => $meal->id]));
        }

        // إضافة الإضافات
        $extras = [
            [
                'name_ar' => 'جبن إضافي',
                'name_en' => 'Extra Cheese',
                'price' => 5.00,
                'category' => 'جبن',
                'sort_order' => 1
            ],
            [
                'name_ar' => 'فطر',
                'name_en' => 'Mushrooms',
                'price' => 8.00,
                'category' => 'خضار',
                'sort_order' => 2
            ],
            [
                'name_ar' => 'زيتون',
                'name_en' => 'Olives',
                'price' => 3.00,
                'category' => 'خضار',
                'sort_order' => 3
            ],
            [
                'name_ar' => 'لحم إضافي',
                'name_en' => 'Extra Meat',
                'price' => 12.00,
                'category' => 'لحوم',
                'sort_order' => 4
            ],
            [
                'name_ar' => 'صوص حار',
                'name_en' => 'Hot Sauce',
                'price' => 2.00,
                'category' => 'صوص',
                'sort_order' => 5
            ]
        ];

        foreach ($extras as $extraData) {
            MealExtra::create(array_merge($extraData, ['meal_id' => $meal->id]));
        }
    }

    /**
     * إضافة أحجام للمشروبات
     */
    private function addDrinkSizes(Meal $drink)
    {
        $sizes = [
            [
                'name_ar' => 'صغير',
                'name_en' => 'Small',
                'price' => $drink->price,
                'additional_price' => 0,
                'is_default' => true,
                'sort_order' => 1
            ],
            [
                'name_ar' => 'متوسط',
                'name_en' => 'Medium',
                'price' => $drink->price + 3,
                'additional_price' => 3,
                'is_default' => false,
                'sort_order' => 2
            ],
            [
                'name_ar' => 'كبير',
                'name_en' => 'Large',
                'price' => $drink->price + 6,
                'additional_price' => 6,
                'is_default' => false,
                'sort_order' => 3
            ]
        ];

        foreach ($sizes as $sizeData) {
            MealSize::create(array_merge($sizeData, ['meal_id' => $drink->id]));
        }
    }
}
