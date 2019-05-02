<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\CrowdfundingProduct;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CrowdfundingProductsController extends Controller
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
            ->header('眾籌商品列表')
            ->description(' ')
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
            ->header('眾籌商品資料')
            ->description(' ')
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
            ->header('編輯眾籌商品')
            ->description(' ')
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
            ->header('建立眾籌商品')
            ->description(' ')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        // 用 Product 來建構模型，不是用 CrowdfundingProduct
        $grid = new Grid(new Product);

        // 只展示類型為眾籌類型的商品
        $grid->model()->where('type', Product::TYPE_CROWDFUNDING);
//
        $grid->id('Id');
        $grid->title('名稱');
        $grid->on_sale('已上架')->display(function ($value) {
            return $value ? '是' : '否';
        });
        $grid->price('價格');
//        // 展示众筹相关字段
        $grid->column('crowdfunding.target_amount', '目標金額');
        $grid->column('crowdfunding.end_at', '結束時間');
        $grid->column('crowdfunding.total_amount', '目前金額');
        $grid->column('crowdfunding.status', ' 狀態')->display(function ($value) {
            return CrowdfundingProduct::$statusMap[$value];
        });
//
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
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
        $show->type('Type');
        $show->category_id('Category id');
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
        // 用 Product 來建構模型，不是用 CrowdfundingProduct
        $form = new Form(new Product);

        // 在表单中添加一个名为 type，值为 Product::TYPE_CROWDFUNDING 的隐藏字段
        $form->hidden('type')->value(Product::TYPE_CROWDFUNDING);
        $form->text('title', '商品名稱')->rules('required');
        $form->select('category_id', '分類')->options(function ($id) {
            $category = Category::find($id);
            if ($category) {
                return [$category->id => $category->full_name];
            }
        })->ajax('/admin/api/categories?is_directory=0');
        $form->image('image', '封面圖片')->rules('required|image');
        $form->textarea('description', '描述')->rules('required');
        $form->radio('on_sale', '上架')->options(['1' => '是', '0' => '否'])->default('0');
        // 透過關聯模型添加眾籌相關欄位
        $form->text('crowdfunding.target_amount', '眾籌目標金額')->rules('required|numeric|min:0.01');
        $form->datetime('crowdfunding.end_at', '眾籌結束時間')->rules('required|date');
        $form->hasMany('skus', '商品 SKU', function (Form\NestedForm $form) {
            $form->text('title', 'SKU 名稱')->rules('required');
            $form->text('description', 'SKU 描述')->rules('required');
            $form->text('price', '單價')->rules('required|numeric|min:0.01');
            $form->text('stock', '剩餘庫存')->rules('required|integer|min:0');
        });

        $form->saving(function (Form $form) {
            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price');
        });

        return $form;
    }
}
