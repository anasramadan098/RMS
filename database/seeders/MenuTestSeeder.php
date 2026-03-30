<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Meal;

class MenuTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء فئات تجريبية
        $categories = [
            [
                'name' => 'الأطباق الرئيسية',
                'description' => 'أطباق رئيسية شهية ومتنوعة',
                'is_active' => true,
                'type' => 'food'
            ],
            [
                'name' => 'المقبلات',
                'description' => 'مقبلات طازجة ولذيذة',
                'is_active' => true,
                'type' => 'food'
            ],
            [
                'name' => 'المشروبات',
                'description' => 'مشروبات باردة وساخنة',
                'is_active' => true,
                'type' => 'drink'
            ],
            [
                'name' => 'الحلويات',
                'description' => 'حلويات شرقية وغربية',
                'is_active' => true,
                'type' => 'dessert'
            ]
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);
            
            // إنشاء وجبات لكل فئة
            $this->createMealsForCategory($category);
        }
    }

    private function createMealsForCategory($category)
    {
        $meals = [];
        
        switch ($category->name) {
            case 'الأطباق الرئيسية':
                $meals = [
                    ['name' => 'كباب مشوي', 'price' => 45.00, 'description' => 'كباب لحم مشوي مع الأرز والسلطة'],
                    ['name' => 'دجاج مشوي', 'price' => 35.00, 'description' => 'دجاج مشوي بالأعشاب مع البطاطس'],
                    ['name' => 'سمك مقلي', 'price' => 50.00, 'description' => 'سمك طازج مقلي مع الخضار'],
                    ['name' => 'برياني لحم', 'price' => 40.00, 'description' => 'أرز برياني باللحم والتوابل'],
                ];
                break;
                
            case 'المقبلات':
                $meals = [
                    ['name' => 'حمص بالطحينة', 'price' => 15.00, 'description' => 'حمص كريمي بالطحينة وزيت الزيتون'],
                    ['name' => 'متبل باذنجان', 'price' => 12.00, 'description' => 'متبل باذنجان مشوي بالثوم'],
                    ['name' => 'فتوش', 'price' => 18.00, 'description' => 'سلطة فتوش بالخضار الطازجة'],
                    ['name' => 'تبولة', 'price' => 16.00, 'description' => 'تبولة بالبقدونس والطماطم'],
                ];
                break;
                
            case 'المشروبات':
                $meals = [
                    ['name' => 'عصير برتقال طازج', 'price' => 8.00, 'description' => 'عصير برتقال طبيعي 100%'],
                    ['name' => 'شاي أحمر', 'price' => 5.00, 'description' => 'شاي أحمر ساخن بالنعناع'],
                    ['name' => 'قهوة عربية', 'price' => 7.00, 'description' => 'قهوة عربية أصيلة بالهيل'],
                    ['name' => 'عصير مانجو', 'price' => 10.00, 'description' => 'عصير مانجو طازج ومنعش'],
                ];
                break;
                
            case 'الحلويات':
                $meals = [
                    ['name' => 'كنافة نابلسية', 'price' => 25.00, 'description' => 'كنافة بالجبن والقطر'],
                    ['name' => 'بقلاوة', 'price' => 20.00, 'description' => 'بقلاوة بالفستق والعسل'],
                    ['name' => 'مهلبية', 'price' => 15.00, 'description' => 'مهلبية بالحليب والفستق'],
                    ['name' => 'أم علي', 'price' => 18.00, 'description' => 'أم علي بالمكسرات والزبيب'],
                ];
                break;
        }

        foreach ($meals as $mealData) {
            Meal::create([
                'name' => $mealData['name'],
                'description' => $mealData['description'],
                'price' => $mealData['price'],
                'category_id' => $category->id,
                'is_active' => true,
                'is_available' => true,
                'preparation_time' => rand(10, 30),
                'image' => null // سنستخدم placeholder images
            ]);
        }
    }
}
