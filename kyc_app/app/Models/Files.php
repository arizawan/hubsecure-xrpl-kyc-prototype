<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_data',
        'user_id',
        'encryption_key',
        'block_uuid',
        'block_data',
        'name',
        'mimetype',
        'filesize',
        'type',
        'document_type',
        'cust_dob',
        'cust_id_number',
        'doc_front',
        'doc_back',
        'live_photo',
        'status'
    ];
}
