<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrlPersona extends Model
{
    protected $table = 'grl.personas';
    protected $primaryKey = 'iPersId';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'cPersUsuarioSis', 'dtPersFechaSis', 'cPersEquipoSis', 'cPersIpSis', 'cPersOpenUsr', 'cPersMacNicSis',
    ];
}
