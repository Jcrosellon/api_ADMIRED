<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadosReservaModel extends Model
{
    protected $table = 'estados_reserva';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['ID', 'DESCRIPCION'];

    // Puedes agregar reglas de validación si es necesario
    protected $validationRules = [
        'ID' => 'required|integer',
        'DESCRIPCION' => 'required|string|max_length[50]'
    ];

    protected $validationMessages = [
        'ID' => [
            'required' => 'El ID es obligatorio.',
            'integer' => 'El ID debe ser un número entero.'
        ],
        'DESCRIPCION' => [
            'required' => 'La descripción es obligatoria.',
            'string' => 'La descripción debe ser una cadena de texto.',
            'max_length' => 'La descripción no puede exceder 50 caracteres.'
        ]
    ];
}
