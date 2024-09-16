<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasModel extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'ID';

    protected $allowedFields = [
        'FECHA_RESERVA',
        'ID_AREA_COMUN',
        'ESTADO_RESERVA',
        'ID_USUARIO',
        'OBSERVACION_ENTREGA',
        'OBSERVACION_RECIBE',
        'VALOR'
    ];

    protected $validationRules = [
        'FECHA_RESERVA' => 'required|valid_date',
        'ID_AREA_COMUN' => 'required|integer',
        'ESTADO_RESERVA' => 'required|string',
        'ID_USUARIO' => 'required|integer',
        'OBSERVACION_ENTREGA' => 'permit_empty|string',
        'OBSERVACION_RECIBE' => 'permit_empty|string',
        'VALOR' => 'required|decimal'
    ];

    protected $validationMessages = [
        'FECHA_RESERVA' => [
            'required' => 'La fecha de reserva es obligatoria.',
            'valid_date' => 'La fecha de reserva no es válida.'
        ],
        'ID_AREA_COMUN' => [
            'required' => 'El área común es obligatoria.',
            'integer' => 'El área común debe ser un número entero.'
        ],
        // Agrega mensajes para las otras reglas si es necesario
    ];

    protected $skipValidation = false;
}
