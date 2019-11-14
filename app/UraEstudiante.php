<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UraEstudiante extends Model
{
    protected $table = 'ura.estudiantes';
    protected $primaryKey = 'iEstudId';

    protected $hidden = [
        'cEstudUsuarioSis', 'dtEstudFechaSis', 'cEstudEquipoSis', 'cEstudIpSis', 'cEstudOpenUsr', 'cEstudMacNicSis',
    ];
}
