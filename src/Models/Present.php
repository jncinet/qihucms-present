<?php

namespace Qihucms\Present\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Present extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'thumbnail', 'image', 'animation', 'pay_currency_type_id', 'pay_amount',
        'unit', 'exchange_currency_type_id', 'exchange_amount', 'exchange_exp',
        'is_broadcast', 'status', 'sort'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'pay_amount' => 'decimal:2',
        'exchange_amount' => 'decimal:2',
        'exchange_exp' => 'integer',
        'is_broadcast' => 'boolean',
        'status' => 'integer',
        'sort' => 'integer',
    ];

    /**
     * @return HasMany
     */
    public function present_order(): HasMany
    {
        return $this->hasMany('Qihucms\Present\Models\PresentOrder');
    }

    /**
     * @return BelongsTo
     */
    public function pay_currency_type(): BelongsTo
    {
        return $this->belongsTo('Qihucms\Currency\Models\CurrencyType');
    }

    /**
     * @return BelongsTo
     */
    public function exchange_currency_type(): BelongsTo
    {
        return $this->belongsTo('Qihucms\Currency\Models\CurrencyType');
    }
}