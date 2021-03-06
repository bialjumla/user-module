<?php

namespace Modules\User\Entities;

use Database\Factories\BrandsFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Scopes\BrandScope;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function booted()
    {
        static::addGlobalScope(new BrandScope);
    }

    protected static function newFactory()
    {
        return BrandsFactory::new();
    }
}
