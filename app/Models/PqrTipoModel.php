<?php

namespace App\Models;

use CodeIgniter\Model;

class PqrTipoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pqr_tipo';
    protected $primaryKey       = 'ID';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['NOMBRE'];

    // No se requiere validación aquí si solo es lectura
}
