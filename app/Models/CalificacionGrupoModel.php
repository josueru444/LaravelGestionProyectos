<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionGrupoModel extends Model
{
    protected $table = 'calificacion_unidad';

    protected $fillable = [
        'unidad', 'data', 'id_grupo'
    ];

    
}
