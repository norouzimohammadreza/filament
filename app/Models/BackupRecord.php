<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackupRecord extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'path',
        'size',
        'disk',
        'is_file',
        'is_database_record',
    ];

}
