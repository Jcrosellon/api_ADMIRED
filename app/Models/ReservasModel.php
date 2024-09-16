<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasModel extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'ID';
    protected $allowedFields = [
        'FECHA_RESERVA',
        'ID_ZONA_COMUN',
        'ESTADO_RESERVA',
        'ID_USUARIO',
        'OBSERVACION_ENTREGA',
        'OBSERVACION_RECIBE',
        'VALOR'
    ];

    protected $validationRules = [
        'FECHA_RESERVA' => 'required|valid_date',
        'ID_ZONA_COMUN' => 'required|numeric',
        'ESTADO_RESERVA' => 'required|string',
        'ID_USUARIO' => 'required|numeric',
        'OBSERVACION_ENTREGA' => 'permit_empty|string',
        'OBSERVACION_RECIBE' => 'permit_empty|string',
        'VALOR' => 'required|decimal',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}
