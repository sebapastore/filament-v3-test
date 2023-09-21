<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => number_format($value, 0, ","),
            set: fn (string $value) => str_replace(',', '', $value),
        );
    }
}
