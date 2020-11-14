<?php

namespace Qihucms\Present\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Qihucms\Present\Present;
use Qihucms\Present\Requests\StoreRequest;
use Qihucms\Present\Resources\GivingOrderCollection;
use Qihucms\Present\Resources\GotOrderCollection;
use Qihucms\Present\Resources\PresentCollection;

class PresentController extends ApiController
{
    protected $present;

    /**
     * PresentController constructor.
     * @param Present $present
     */
    public function __construct(Present $present)
    {
        $this->middleware('auth');
        $this->present = $present;
    }

    /**
     * 礼物列表
     *
     * @param Request $request
     * @return PresentCollection
     */
    public function presents(Request $request)
    {
        $limit = $request->get('limit', 15);
        // 支付货币类型
        $pay_currency_type_id = (int)$request->get('pay_type_id', 0);
        // 兑换货币类型
        $exchange_currency_type_id = (int)$request->get('exchange_type_id', 0);
        // 礼物名称
        $name = $request->get('name');

        $condition = [['status', '=', 1]];

        if ($pay_currency_type_id) {
            $condition[] = ['pay_currency_type_id', '=', $pay_currency_type_id];
        }

        if ($exchange_currency_type_id) {
            $condition[] = ['exchange_currency_type_id', '=', $exchange_currency_type_id];
        }

        if (empty($name)) {
            $condition[] = ['name', 'like', '%' . $name . '%'];
        }

        $result = $this->present->presentPaginate($condition, $limit);

        return new PresentCollection($result);
    }

    /**
     * 礼物订单记录
     *
     * @param Request $request
     * @return GivingOrderCollection|GotOrderCollection
     */
    public function orders(Request $request)
    {
        $limit = $request->get('limit', 15);
        // 订单状态，默认1为成功的订单
        $status = $request->get('status', 1);
        // 送礼物的会员ID
        $user_id = (int)$request->get('user_id', 0);
        // 收礼物的会员ID
        $to_user_id = (int)$request->get('to_user_id', 0);
        // 礼物ID
        $present_id = (int)$request->get('present_id', 0);
        // 类型：送出的礼物0、收到的礼物1
        $type = $request->get('type', 0);

        $condition = [['status', '=', $status]];

        if ($user_id) {
            $condition[] = ['user_id', '=', $user_id];
        }

        if ($to_user_id) {
            $condition[] = ['to_user_id', '=', $to_user_id];
        }

        if ($present_id) {
            $condition[] = ['present_id', '=', $present_id];
        }

        $result = $this->present->orderPaginate($condition, $limit);

        if ($type == 1) {
            return new GotOrderCollection($result);
        }

        return new GivingOrderCollection($result);
    }

    /**
     * 送礼物
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function giving(StoreRequest $request)
    {
        $data = $request->only(['present_id', 'to_user_id']);
        $data['user_id'] = Auth::id();
        $data['status'] = 1;

        $result = $this->present->createOrder($data);

        if ($result) {
            return $this->jsonResponse(
                ['to_user_id' => $data['to_user_id'], 'present_id' => $data['present_id']],
                __('present::message.giving_success'));
        }

        return $this->jsonResponse([__('present::message.giving_fail')], '', 422);
    }
}