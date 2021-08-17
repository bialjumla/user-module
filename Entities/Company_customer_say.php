<?php

namespace Modules\UserModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Company_customer_say extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

}

