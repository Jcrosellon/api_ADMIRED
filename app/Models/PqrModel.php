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
        'FECHA_RESPUESTA' => 'valid_date',
        'RESPUESTA' => 'permit_empty',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
}
