<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;

class ClientStat extends Model
{
    use HasFactory;

    protected $table = "client_stats";

    protected $fillable = [
        // 'id',
        'instance',
        'IP',
        'browser',
        'blob',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'blob' => AsCollection::class,
    ];


}
