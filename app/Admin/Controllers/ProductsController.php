<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;


class ProductsController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('商品列表')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('編輯商品')
            ->description('description')
            ->body($this->form()->edit($id));

    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('創建商品')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);

        $grid->id('Id')->sortable();
        $grid->title('商品名稱');
        $grid->on_sale('On sale')->display(function ($value) {
            return $value ? '是' : '否';
        });;
        $grid->rating('評分');
        $grid->sold_count('銷量');
        $grid->review_count('評論數');
        $grid->price('價格');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $show->id('Id');
        $show->title('Title');
        $show->description('Description');
        $show->image('Image');
        $show->on_sale('On sale');
        $show->rating('Rating');
        $show->sold_count('Sold count');
        $show->review_count('Review count');
        $show->price('Price');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product);

        $form->text('title', '商品名稱')->rules('required');
        $form->image('image', '封面圖片')->rules('required|image');
        $form->textarea('description', '描述')->rules('required');
        $form->switch('on_sale', '上架')->options(['1' => '是', '0'=> '否'])->default('0');

        /**
         * 直接添加一对多的关联模型
         * 第一個參數必須和主模型中定義此關聯關係的方法同名，我們之前在App\Models\Product 類中定義了skus() 方法來關聯SKU，因此這裡我們需要填入skus
         * 第二個參數是對這個關聯關係的描述
         * 第三個參數是一個匿名函數，用來定義關聯模型的字段
         */
        $form->hasMany('skus', 'SKU 列表', function (Form\NestedForm $form) {
            $form->text('title', 'SKU 名稱')->rules('required');
            $form->text('description', 'SKU 描述')->rules('required');
            $form->text('price', '單價')->rules('required|numeric|min:0.01');
            $form->text('stock', '剩餘庫存')->rules('required|integer|min:0');
        });

        /**
         * 定義事件回調，當模型即將保存時會觸發這個回調
         * 保存後將最低價的SKU價格存入商品價格中
         */
        $form->saving(function (Form $form) {
            $form->model()->price = collect($form->input('skus'))
                ->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;
        });

        return $form;
    }
}
