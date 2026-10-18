<?php

declare(strict_types=1);

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'pro_id',
        'pro_name',
        'pro_quantity',
        'product_price',
        'sub_total',
    ];
}
