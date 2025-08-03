<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status_id', 'due_date'];

    protected $casts = [
        'due_date' => 'date:d/m/Y',
    ];
}
