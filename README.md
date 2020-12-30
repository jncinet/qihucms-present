## 安装

```shell
$ composer require jncinet/qihucms-present
```

## 使用

### 数据迁移
```shell
$ php artisan migrate
```

### 发布资源
```shell
$ php artisan vendor:publish --provider="Qihucms\Present\PresentServiceProvider"
```

## 后台菜单
+ 礼物列表 `present/presents`
+ 礼物订单 `present/orders`

### 路由能参数说明

#### 礼物列表

```php
route('api.present.index')
请求：GET
地址：/present/presents?pay_type_id={$pay_type_id}&...&page={$page}&limit={$limit}
参数：
int          $pay_type_id      （选填）支付货币类型
int          $exchange_type_id （选填）兑换货币类型
string       $name             （选填）根据礼物名模糊查询
int          $page             （选填）页码
int          $limit            （选填）每页显示的条数
返回值：
{
    data: [
        {
            id：礼物ID
            name：礼物名字
            thumbnail：礼物小图
            image：礼物大图
            animation：动画
            pay_currency_type：付款币类型
            pay_amount：付款数额
            unit: 礼物计数单位,
        },
        ...
    ],
    meta: {},
    links: {}
}

```

#### 礼物订单列表

```php
route('api.present.order')
请求：GET
地址：/present/orders?user_id={$user_id}&...&page={$page}&limit={$limit}
参数：
int          $user_id          （选填）送礼物会员ID
int          $to_user_id       （选填）收礼物会员ID
int          $present_id       （选填）礼物ID
0|1          $type             （选填）送出的礼物0、收到的礼物1
0|1|2        $status           （选填）礼物订单状态0失败订单，1成功订单，2异常订单
int          $page             （选填）页码
int          $limit            （选填）每页显示的条数
返回值：
{
    data: [
        {
            id：礼物ID
            present：{礼物信息}
            to_user：{收礼会员信息}  // 参数type为0时存在
            to_user_id：收礼会员ID  // 参数type为1时存在
            user：{送礼会员信息}    // 参数type为1时存在
            user_id：送礼会员ID    // 参数type为0时存在
            status：订单状态
            created_at：创建时间
            updated_at: 更新时间,
        },
        ...
    ],
    meta: {},
    links: {}
}

```

#### 送礼物

```php
route('api.present.givings')
请求：POST
地址：/present/givings
参数：
int $present_id （必填）礼物ID
int $to_user_id （必填）收礼会员ID
返回值：
{
    status: 'SUCCESS',
    result: {
        to_user_id: 礼物ID
        present_id：收礼会员ID
    }
}
```

### 事件调用

```php
// 创建订单
Qihucms\Present\Events\GivingPresent
```

## 数据库
### 礼物表：presents
| Field             | Type      | Length    | AllowNull | Default   | Comment   |
| :----             | :----     | :----     | :----     | :----     | :----     |
| id                | bigint    |           |           |           |           |
| name              | varchar   | 55        |           |           | 礼物名称   |
| thumbnail         | varchar   | 255       |  Y        | NULL      | 礼物图标   |
| image             | varchar   | 255       |  Y        | NULL      | 礼物大图   |
| animation         | varchar   | 255       |  Y        | NULL      | 礼物动效   |
| pay_currency_type_id | bigint |           |           |           | 支付货币类型 |
| pay_amount        | decimal   |           |           | 0.00      | 支付数额   |
| unit              | varchar   | 15        |           |           | 计数单位   |
| exchange_currency_type_id | bigint |      |           |           | 兑换货币类型 |
| exchange_amount   | decimal   |           |           | 0.00      | 兑换数额   |
| exchange_exp      | int       |           |           | 0         | 兑换经验   |
| is_broadcast      | tinyint   |           |           | 0         | 是否广播   |
| status            | tinyint   |           |           | 0         | 状态      |
| sort              | int       |           |           | 0         | 排序      |
| created_at        | timestamp |           | Y         | NULL      | 创建时间   |
| updated_at        | timestamp |           | Y         | NULL      | 更新时间   |

### 礼物订单表：present_orders
| Field             | Type      | Length    | AllowNull | Default   | Comment   |
| :----             | :----     | :----     | :----     | :----     | :----     |
| id                | bigint    |           |           |           |           |
| user_id           | bigint    |           |           |           | 送礼会员id |
| to_user_id        | bigint    |           |           |           | 收礼会员id |
| present_id        | bigint    |           |           |           | 礼物id    |
| status            | tinyint   |           |           | 0         | 状态      |
| created_at        | timestamp |           | Y         | NULL      | 创建时间   |
| updated_at        | timestamp |           | Y         | NULL      | 更新时间   |
