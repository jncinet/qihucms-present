<?php

namespace Qihucms\Present;

use Qihucms\Currency\Currency;
use Qihucms\Present\Models\Present as PresentModel;
use Qihucms\Present\Models\PresentOrder;

class Present
{
    /**
     * 礼物详细
     *
     * @param $id
     * @return mixed
     */
    public function findPresentById($id)
    {
        return PresentModel::find($id);
    }

    /**
     * 礼物列表
     *
     * @param array $condition
     * @param int $limit
     * @return mixed
     */
    public function presentPaginate($condition = [], $limit = 15)
    {
        return PresentModel::where($condition)->orderBy('id', 'desc')
            ->orderBy('sort', 'desc')->paginate($limit);
    }

    /**
     * 订单详细
     *
     * @param $id
     * @return mixed
     */
    public function findOrderById($id)
    {
        return PresentOrder::find($id);
    }

    /**
     * 礼物记录
     *
     * @param array $condition
     * @param int $limit
     * @return mixed
     */
    public function orderPaginate($condition = [], $limit = 15)
    {
        return PresentOrder::where($condition)->orderBy('id', 'desc')->paginate($limit);
    }

    /**
     * 创建订单
     *
     * @param array $data
     * @return mixed
     */
    public function createOrder($data = [])
    {
        $present = $this->findPresentById($data['present_id']);

        $result = PresentOrder::create($data);

        if ($result) {
            // $data['user_id'] 出账
            $resultExpend = Currency::expend($data['user_id'], $present->pay_currency_type_id,
                $present->pay_amount, 'giving_present', $result->id);

            if ($resultExpend === 100) {
                // $data['to_user_id'] 入账
                $resultEntry = Currency::entry($data['to_user_id'], $present->exchange_currency_type_id,
                    $present->exchange_amount, 'got_present', $result->id);

                if ($resultEntry !== 100) {
                    $result->status = 2;
                }
            } else {
                $result->status = 0;
            }
        }

        return $result;
    }
}