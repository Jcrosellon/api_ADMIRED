<?php

namespace App\Models;

use CodeIgniter\Model;

class UnidadesResidencialesModel extends Model
{
    protected $table = 'unidades_residenciales';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['NO_TORRE', 'NO_APARTAMENTO', 'ID_PROPIETARIO', 'VALOR_CUOTA'];

    public function getByUserId($userId)
    {
        // Consulta para obtener la unidad residencial por el ID del propietario
        return $this->where('ID_PROPIETARIO', $userId)->first(); // Devuelve la primera coincidencia
    }
}
