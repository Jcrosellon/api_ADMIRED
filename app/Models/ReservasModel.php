<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasModel extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['FECHA_RESERVA', 'ID_ZONA_COMUN', 'ESTADO_RESERVA', 'ID_USUARIO', 'OBSERVACION_ENTREGA', 'OBSERVACION_RECIBE', 'VALOR'];
}
