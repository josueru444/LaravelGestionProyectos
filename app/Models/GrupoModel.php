<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoModel extends Model
{

    protected $table = 'grupo';
    //protected $keyType = 'string';
    use HasFactory;
    protected $fillable=['uuid','nombre','clave','creditos'];
}
