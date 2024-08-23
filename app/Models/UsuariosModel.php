<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'usuarios';
    protected $primaryKey       = 'ID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'NOMBRE',
        'APELLIDO',
        'TIPO_DOCUMENTO_ID',
        'NO_DOCUMENTO',
        'FECHA_NACIMIENTO',
        'EMAIL',
        'CONTRASENA',
        'TELEFONO',
        'ROL_ID',
        'TORRE',
        'APTO',
        'PQR_ID',
        'RESIDENTES_ID',
        'CUOTAS_ADMIN_ID',
        'UNIDAD_RESIDENCIAL_ID',
        'AREA_COMUN_ID'
    ];

    protected $validationRules = [
        'NOMBRE' => 'required|string|min_length[3]',
        'APELLIDO' => 'required|string|min_length[3]',
        'TIPO_DOCUMENTO_ID' => 'required|numeric',
        'NO_DOCUMENTO' => 'required|numeric',
        'FECHA_NACIMIENTO' => 'required|valid_date',
        'EMAIL' => 'required|valid_email',
        'CONTRASENA' => 'required|min_length[8]',
        'TELEFONO' => 'required|numeric|min_length[7]|max_length[15]',
        'ROL_ID' => 'required|numeric',
        'TORRE' => 'required|numeric',
        'APTO' => 'required|numeric',
    ];

    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
