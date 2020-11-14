<?php

namespace Qihucms\Present\Controllers\Admin;

use App\Admin\Controllers\Controller;
use Qihucms\Currency\Models\CurrencyType;
use Qihucms\Present\Models\Present;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PresentController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '礼物管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Present);

        $grid->model()->orderBy('sort', 'desc')->latest();

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('name', __('present::present.name'));
            $filter->equal('status', __('present::present.status.label'))->select(__('present::present.status.value'));
        });

        $grid->column('sort', __('present::present.sort'))->editable();
        $grid->column('id', __('present::present.id'));
        $grid->column('name', __('present::present.name'));
        $grid->column('thumbnail', __('present::present.thumbnail'))->image('', 66);
        $grid->column('pay_currency_type.name', __('present::present.pay_currency_type_id'));
        $grid->column('pay_amount', __('present::present.pay_amount'));
        $grid->column('exchange_currency_type.name', __('present::present.exchange_currency_type_id'));
        $grid->column('exchange_amount', __('present::present.exchange_amount'));
        $grid->column('exchange_exp', __('present::present.exchange_exp'));
        $grid->column('status', __('present::present.status.label'))
            ->using(__('present::present.status.value'));

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
        $show = new Show(Present::findOrFail($id));

        $show->field('id', __('present::present.id'));
        $show->field('name', __('present::present.name'));
        $show->field('thumbnail', __('present::present.thumbnail'))->image();
        $show->field('image', __('present::present.image'))->file();
        $show->field('animation', __('present::present.animation.label'))
            ->using(__('present::present.animation.value'));
        $show->field('pay_currency_type_id', __('present::present.pay_currency_type_id'))
            ->as(function () {
                return $this->pay_currency_type ? $this->pay_currency_type->name : '货币类型已删除';
            });
        $show->field('pay_amount', __('present::present.pay_amount'));
        $show->field('unit', __('present::present.unit'));
        $show->field('exchange_currency_type_id', __('present::present.exchange_currency_type_id'))
            ->as(function () {
                return $this->exchange_currency_type ? $this->exchange_currency_type->name : '货币类型已删除';
            });
        $show->field('exchange_amount', __('present::present.exchange_amount'));
        $show->field('exchange_exp', __('present::present.exchange_exp'));
        $show->field('is_broadcast', __('present::present.is_broadcast.label'))
            ->using(__('present::present.is_broadcast.value'));
        $show->field('status', __('present::present.status.label'))
            ->using(__('present::present.status.value'));
        $show->field('sort', __('present::present.sort'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Present);

        $form->text('name', __('present::present.name'));
        $form->image('thumbnail', __('present::present.thumbnail'))
            ->removable()
            ->uniqueName()
            ->move('present/thumbnail');
        $form->file('image', __('present::present.image'))
            ->removable()
            ->uniqueName()
            ->move('present/image');
        $form->select('animation', __('present::present.animation.label'))
            ->default('no')
            ->options(__('present::present.animation.value'));
        $form->select('pay_currency_type_id', __('present::present.pay_currency_type_id'))
            ->options(CurrencyType::all()->pluck('name', 'id'));
        $form->currency('pay_amount', __('present::present.pay_amount'))
            ->default(0)
            ->symbol('¥');
        $form->text('unit', __('present::present.unit'))
            ->default('件');
        $form->select('exchange_currency_type_id', __('present::present.exchange_currency_type_id'))
            ->options(CurrencyType::all()->pluck('name', 'id'));
        $form->currency('exchange_amount', __('present::present.exchange_amount'))
            ->default(0)->symbol('¥');
        $form->number('exchange_exp', __('present::present.exchange_exp'))
            ->default(0)->min(0);
        $form->select('is_broadcast', __('present::present.is_broadcast.label'))
            ->options(__('present::present.is_broadcast.value'));
        $form->select('status', __('present::present.status.label'))
            ->default(1)
            ->options(__('present::present.status.value'));
        $form->number('sort', __('present::present.sort'))
            ->default(0)
            ->min(0);

        return $form;
    }
}