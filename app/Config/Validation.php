<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $reservas = [
        'FECHA_RESERVA' => 'required|valid_date',
        'ID_AREA_COMUN' => 'required|integer',
        'ESTADO_RESERVA' => 'required|string',
        'ID_USUARIO' => 'required|integer',
        'OBSERVACION_ENTREGA' => 'permit_empty|string',
        'OBSERVACION_RECIBE' => 'permit_empty|string',
        'VALOR' => 'required|decimal',
    ];

    public $pqr = [
        'DETALLE' => [
            'rules' => 'required|string',
            'errors' => [
                'required' => 'El campo detalle es obligatorio.',
                'string' => 'El campo detalle debe ser una cadena de texto válida.'
            ]
        ],
        'ESTADO_ID' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'El campo estado es obligatorio.',
                'numeric' => 'El campo estado debe ser un número.'
            ]
        ],
        'USUARIO_ID' => [
            'rules' => 'required|integer', // Asegúrate de validar el usuario
            'errors' => [
                'required' => 'El campo usuario es obligatorio.',
                'integer' => 'El campo usuario debe ser un número entero.'
            ]
        ],
        'PQR_TIPO_ID' => [
            'rules' => 'required|integer', // Asegúrate de validar el tipo de PQR
            'errors' => [
                'required' => 'El campo tipo de PQR es obligatorio.',
                'integer' => 'El campo tipo de PQR debe ser un número entero.'
            ]
        ],
        'FECHA_RESPUESTA' => [
            'rules' => 'permit_empty|valid_date', // Opcional, pero debe ser una fecha válida si se proporciona
            'errors' => [
                'valid_date' => 'La fecha de respuesta debe ser una fecha válida.'
            ]
        ],
        'RESPUESTA' => [
            'rules' => 'permit_empty|string', // Opcional
            'errors' => [
                'string' => 'La respuesta debe ser una cadena de texto válida.'
            ]
        ],
    ];


    // Validation.php
    public $cuota = [
        'FECHA_MES' => 'required|valid_date',
        'ESTADO' => 'required|string',
        'VALOR' => 'required|decimal',
        'NO_APTO' => 'permit_empty|string',
        'FECHA_PAGO' => 'permit_empty|valid_date',
    ];
}
