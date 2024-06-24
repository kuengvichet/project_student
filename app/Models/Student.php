<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'class',
        'created_at',
        'updated_at'
    ];
}
