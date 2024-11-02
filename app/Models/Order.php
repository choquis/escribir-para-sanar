<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    protected $fillable = [
        'order_key',
        'status',
        'response'
    ];
    protected function casts(): array
    {
        return [
            'response' => AsArrayObject::class,
        ];
    }
    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class);
    }
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    public function canEdit()
    {
        return str_contains('SYS-', $this->order_key);
    }
}
