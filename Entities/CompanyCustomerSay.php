<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CompanyCustomerSay extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = "company_customers_say";

}

