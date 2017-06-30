<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintSummaries extends Model
{
    protected $fillable = [
        'product',
        'company',
        'count',
        'date_summarized'
    ];
}
