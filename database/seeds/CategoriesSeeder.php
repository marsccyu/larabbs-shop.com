<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name'     => '手機配件',
                'children' => [
                    ['name' => '手機殼'],
                    ['name' => '貼膜'],
                    ['name' => '記憶卡'],
                    ['name' => '傳輸線'],
                    ['name' => '充電器'],
                    [
                        'name'     => '耳機',
                        'children' => [
                            ['name' => '有線耳機'],
                            ['name' => '藍芽耳機'],
                        ],
                    ],
                ],
            ],
            [
                'name'     => '電腦配件',
                'children' => [
                    ['name' => '螢幕'],
                    ['name' => '顯示卡'],
                    ['name' => '記憶體'],
                    ['name' => 'CPU'],
                    ['name' => '主機板'],
                    ['name' => '硬碟'],
                ],
            ],
            [
                'name'     => '電腦',
                'children' => [
                    ['name' => '筆記型電腦'],
                    ['name' => '桌機'],
                    ['name' => '平板電腦'],
                    ['name' => '一體機'],
                    ['name' => '伺服器'],
                    ['name' => '工作站'],
                ],
            ],
            [
                'name'     => '手機通訊',
                'children' => [
                    ['name' => '智慧型手機'],
                    ['name' => '長輩機'],
                    ['name' => '對講機'],
                ],
            ],
        ];

        foreach ($categories as $data) {
            $this->createCategory($data);
        }
    }

    protected function createCategory($data, $parent = null)
    {
        // 创建一个新的类目对象
        $category = new Category(['name' => $data['name']]);
        // 如果有 children 字段则代表这是一个父类目
        $category->is_directory = isset($data['children']);
        // 如果有传入 $parent 参数，代表有父类目
        if (!is_null($parent)) {
            $category->parent()->associate($parent);
        }
        //  保存到数据库
        $category->save();
        // 如果有 children 字段并且 children 字段是一个数组
        if (isset($data['children']) && is_array($data['children'])) {
            // 遍历 children 字段
            foreach ($data['children'] as $child) {
                // 递归调用 createCategory 方法，第二个参数即为刚刚创建的类目
                $this->createCategory($child, $category);
            }
        }
    }
}
