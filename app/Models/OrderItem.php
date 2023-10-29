<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    public function orderable()
    {
        return $this->morphTo();
    }
  }
