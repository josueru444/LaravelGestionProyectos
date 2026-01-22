<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnosModel extends Model
{
    protected $table = '_alumnos';
    protected $fillable = [
        'nc',
        'ap',
        'am',
        'nombres',
    ];
}
