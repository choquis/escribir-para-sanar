<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Event extends Model
{
    use SoftDeletes;
    protected $table = 'events';
    protected $fillable = [
        'name',
        'date',
        'cap',
        'price',
        'hide'
    ];
    protected $attributes = [
        'cap' => 15,
        'price' => 100
    ];

    protected $appends = ['only_date', 'only_time', 'formatted_date', 'formatted_time'];

    protected function onlyDate(): Attribute
    {
        return new Attribute(
            get: fn() => (new Carbon($this->date, 'UTC'))->setTimezone('America/Monterrey')->format('Y-m-d'),
        );
    }
    protected function onlyTime(): Attribute
    {
        return new Attribute(
            get: fn() => (new Carbon($this->date, 'UTC'))->setTimezone('America/Monterrey')->format('H:i'),
        );
    }
    protected function formattedDate(): Attribute
    {
        return new Attribute(
            get: fn() => (new Carbon($this->date, 'UTC'))->setTimezone('America/Monterrey')->locale('es')->isoFormat('dddd D MMMM'),
        );
    }
    protected function formattedTime(): Attribute
    {
        return new Attribute(
            get: fn() => (new Carbon($this->date, 'UTC'))->setTimezone('America/Monterrey')->locale('es')->isoFormat('h:mm a'),
        );
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
