<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
       'date_received',
        'product',
        'sub_product',
        'issue',
        'sub_issue',
        'complaint_what_happened',
        'company_public_response',
        'company',
        'state',
        'zip_code',
        'tags',
        'consumer_consent_provided',
        'submitted_via',
        'date_sent_to_company',
        'company_response',
        'timely',
        'consumer_disputed',
        'complaint_id',
    ];
}
