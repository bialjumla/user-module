<?php

namespace Modules\User\Entities;

use App\Models\User;
use App\Scopes\DateFilterScope;
use Database\Factories\OffersFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Scopes\OfferScope;

class Offer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new OfferScope);
        static::addGlobalScope(new DateFilterScope);
    }

    protected static function newFactory()
    {
        return OffersFactory::new();
    }


}
