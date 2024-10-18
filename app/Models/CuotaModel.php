<?php

namespace App\Models;

use CodeIgniter\Model;

class CuotaModel extends Model
{
    protected $table = 'cuotas_administracion';
    protected $primaryKey = 'ID';
    protected $allowedFields = [
        'FECHA_MES',
        'ESTADO',
        'VALOR',
        'NO_APTO',
        'FECHA_PAGO',
        'UNIDAD_RESIDENCIAL_ID',
        'USUARIO_ID',
    ];

    public function cuotaExistente($unidadId, $fechaMes)
    {
        return $this->where('UNIDAD_RESIDENCIAL_ID', $unidadId)
            ->where('FECHA_MES', $fechaMes)
            ->first();
    }

    // Método para obtener las cuotas por usuario
    public function getCuotasByUserId($usuarioId)
    {
        return $this->where('USUARIO_ID', $usuarioId)->findAll();
    }
}
