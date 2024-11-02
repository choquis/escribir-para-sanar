<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Email extends Model
{
    use SoftDeletes;
    protected $table = 'emails';
    protected $fillable = [
        'name',
        'email',
        'newsletter',
    ];
    protected $attributes = [
        'newsletter' => 0
    ];
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
