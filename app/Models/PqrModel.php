<?php

namespace App\Models;

use CodeIgniter\Model;

class PqrModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pqr';
    protected $primaryKey       = 'ID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['DETALLE', 'ESTADO_ID', 'USUARIO_ID', 'PQR_TIPO_ID', 'FECHA_SOLICITUD', 'FECHA_RESPUESTA', 'RESPUESTA'];

    protected $validationRules = [
        'DETALLE' => 'required',
        'ESTADO_ID' => 'required|integer',
        'USUARIO_ID' => 'required|integer',
        'PQR_TIPO_ID' => 'required|integer',
        'FECHA_SOLICITUD' => 'required|valid_date',
        'FECHA_RESPUESTA' => 'permit_empty|valid_date', // Cambiado aquí
        'RESPUESTA' => 'permit_empty',
    ];


    protected $validationMessages = [
        'DETALLE' => [
            'required' => 'El detalle es obligatorio.',
        ],
        'ESTADO_ID' => [
            'required' => 'El estado es obligatorio.',
            'integer' => 'El estado debe ser un número entero.',
        ],
        'USUARIO_ID' => [
            'required' => 'El ID de usuario es obligatorio.',
            'integer' => 'El ID de usuario debe ser un número entero.',
        ],
        'PQR_TIPO_ID' => [
            'required' => 'El tipo de PQR es obligatorio.',
            'integer' => 'El tipo de PQR debe ser un número entero.',
        ],
        'FECHA_SOLICITUD' => [
            'required' => 'La fecha de solicitud es obligatoria.',
            'valid_date' => 'La fecha de solicitud no es válida.',
        ],
        'FECHA_RESPUESTA' => [
            'valid_date' => 'La fecha de respuesta no es válida.',
        ],
        'RESPUESTA' => [
            'permit_empty' => 'La respuesta es opcional.',
        ],
    ];

    protected $skipValidation = false;
}
