<?php
return [
    'id' => '礼物ID',
    'name' => '礼物名称',
    'thumbnail' => '礼物图标',
    'image' => '动效大图',
    'animation' => [
        'label' => '动效',
        'value' => [
            'no' => '无',
            'up' => '向上滑动',
            'down' => '向下滑动',
            'left' => '向左滑动',
            'right' => '向右滑动',
        ]
    ],
    'pay_currency_type_id' => '支付货币类型',
    'pay_amount' => '支付数额',
    'unit' => '礼物单位',
    'exchange_currency_type_id' => '获得货币类型',
    'exchange_amount' => '获得数额',
    'exchange_exp' => '获得经验',
    'is_broadcast' => [
        'label' => '广播',
        'value' => ['否', '是']
    ],
    'status' => [
        'label' => '状态',
        'value' => ['下架', '上架']
    ],
    'sort' => '排序',
];
