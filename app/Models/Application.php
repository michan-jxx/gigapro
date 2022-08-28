<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class application extends Model
{
    use HasFactory;

     /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'application';

    protected $guarded =
    [
        'id',
        'created_at',
        'updated_at',
    ];
}
