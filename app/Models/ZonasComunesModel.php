<?php

namespace App\Models;

use CodeIgniter\Model;

class ZonasComunesModel extends Model
{
    protected $table = 'zonas_comunes';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['NOMBRE', 'DESCRIPCION', 'IMAGEN_URL', 'PRECIO', 'DISPONIBILIDAD'];
}
