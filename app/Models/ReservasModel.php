<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasModel extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'ID';

    protected $allowedFields = [
        'FECHA_RESERVA',
        'FECHA_FIN',
        'ID_AREA_COMUN',
        'ID_USUARIO',
        'OBSERVACION_ENTREGA',
        'OBSERVACION_RECIBE',
        'VALOR',
        'ID_ESTADO_RESERVA'  // Asegúrate de que este campo esté aquí
    ];

    protected $validationRules = [
        'FECHA_RESERVA' => 'required|valid_date[Y-m-d H:i:s]',
        'FECHA_FIN' => 'required|valid_date[Y-m-d H:i:s]',
        'ID_AREA_COMUN' => 'required|integer',
        'ID_USUARIO' => 'required|integer',
        'OBSERVACION_ENTREGA' => 'permit_empty|string',
        'OBSERVACION_RECIBE' => 'permit_empty|string',
        'VALOR' => 'required|decimal',
        'ID_ESTADO_RESERVA' => 'required|integer',
    ];

    protected $validationMessages = [
        'FECHA_RESERVA' => [
            'required' => 'La fecha de reserva es obligatoria.',
            'valid_date' => 'La fecha de reserva no es válida.'
        ],
        'FECHA_FIN' => [
            'required' => 'La fecha de fin es obligatoria.',
            'valid_date' => 'La fecha de fin no es válida.',
            // El mensaje 'greater_than' no es necesario aquí, ya que la validación de fechas se hace en el controlador.
        ],
        'ID_AREA_COMUN' => [
            'required' => 'El área común es obligatoria.',
            'integer' => 'El área común debe ser un número entero.'
        ],
    ];

    protected $skipValidation = false;

    // Permite agregar reglas dinámicamente si es necesario
    public function getValidationRules(array $options = []): array
    {
        return array_merge($this->validationRules, $options);
    }
}
