<?php

namespace App\Models;

use CodeIgniter\Model;

class CuotaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'cuotas_administracion';
    protected $primaryKey       = 'ID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['FECHA_MES', 'ESTADO', 'VALOR', 'NO_APTO', 'FECHA_PAGO'];

    protected $validationRules = [
        'FECHA_MES' => 'required|valid_date',
        'ESTADO' => 'required|string',
        'VALOR' => 'required|decimal',
        'NO_APTO' => 'permit_empty|string',
        'FECHA_PAGO' => 'permit_empty|valid_date',
    ];
}
