<?php

namespace Qihucms\Present\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Qihucms\Present\Events\GivingPresent;

class PresentOrder extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'present_id', 'user_id', 'to_user_id', 'status'
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = ['created' => GivingPresent::class];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return BelongsTo
     */
    public function to_user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return BelongsTo
     */
    public function present(): BelongsTo
    {
        return $this->belongsTo('Qihucms\Present\Models\Present');
    }
}