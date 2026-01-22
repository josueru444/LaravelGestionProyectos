<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoGrupoModel extends Model
{
    use HasFactory;
    //protected $keyType = 'string';
    protected $table='grupo_alumno';
    protected $keyType = 'string';
    protected $fillable = ['nc_alumno', 'id_grupo','status'];
}
