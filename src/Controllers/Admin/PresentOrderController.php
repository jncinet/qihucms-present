<?php

namespace Qihucms\Present\Controllers\Admin;

use App\Admin\Controllers\Controller;
use Qihucms\Present\Models\PresentOrder;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PresentOrderController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '送礼日志';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PresentOrder);

        $grid->model()->latest();
        $grid->disableCreateButton();
        $grid->disableActions();

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('present.name', __('present::order.present_id'));
            $filter->like('user.username', __('present::order.user_id'));
            $filter->like('to_user.username', __('present::order.to_user_id'));
            $filter->equal('status', __('present::order.status.label'))->select(__('present::order.status.value'));
            $filter->between('created_at', __('admin.created_at'))->date();
        });

        $grid->column('id', __('present::order.id'));
        $grid->column('present.name', __('present::order.present_id'));
        $grid->column('user.username', __('present::order.user_id'));
        $grid->column('to_user.username', __('present::order.to_user_id'));
        $grid->column('status', __('present::order.status.label'))
            ->using(__('present::order.status.value'))
            ->dot(['default', 'success']);
        $grid->column('created_at', __('admin.created_at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(PresentOrder::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PresentOrder);

        return $form;
    }
}
