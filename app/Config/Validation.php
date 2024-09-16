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
        'DETALLE' => 'required|string',
        'ESTADO_ID' => 'required|numeric',
        'USUARIO_ID' => 'required|numeric',
        'PQR_TIPO_ID' => 'required|numeric',  // Actualizado aquí
        'FECHA_SOLICITUD' => 'required|valid_date',
        'FECHA_RESPUESTA' => 'permit_empty|valid_date',
        'RESPUESTA' => 'permit_empty|string',
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
