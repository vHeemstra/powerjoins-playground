<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class Course extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    public function order_items()
    {
        return $this->morphMany(OrderItem::class, 'orderable');
    }
}
