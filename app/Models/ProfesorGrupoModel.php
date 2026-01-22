<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorGrupoModel extends Model
{
    protected $table = 'grupo_profesor';
    protected $keyType = 'string';
    use HasFactory;
    protected $fillable=['uuid','id_profesor','id_grupo','num_unidades'];
}
