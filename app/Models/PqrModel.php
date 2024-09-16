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
    protected $protectFields    = true;
    protected $allowedFields    = [
        'DETALLE',
        'ESTADO_ID',
        'USUARIO_ID',
        'PQR_TIPO_ID',  // Actualizado aquí
        'FECHA_SOLICITUD',
        'FECHA_RESPUESTA',
        'RESPUESTA',
    ];

    protected $validationRules = [
        'DETALLE' => 'required|string',
        'ESTADO_ID' => 'required|numeric',
        'USUARIO_ID' => 'required|numeric',
        'PQR_TIPO_ID' => 'required|numeric',  // Actualizado aquí
        'FECHA_SOLICITUD' => 'required|valid_date',
        'FECHA_RESPUESTA' => 'permit_empty|valid_date',
        'RESPUESTA' => 'permit_empty|string',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}
