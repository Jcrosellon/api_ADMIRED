<?php

namespace App\Models;

use CodeIgniter\Model;

class AreasComunesModel extends Model
{
    protected $table = 'areas_comunes'; // Asegúrate de que el nombre de la tabla es correcto
    protected $primaryKey = 'ID';
    protected $allowedFields = [
        'NOMBRE',
        'DESCRIPCION',
        'IMAGEN_URL',
        'PRECIO',
        'DISPONIBILIDAD'
    ];

    protected $validationRules = [
        'NOMBRE' => 'required|string|max_length[100]',
        'DESCRIPCION' => 'permit_empty|string',
        'IMAGEN_URL' => 'permit_empty|valid_url|max_length[255]',
        'PRECIO' => 'permit_empty|decimal',
        'DISPONIBILIDAD' => 'permit_empty|integer'
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
}
