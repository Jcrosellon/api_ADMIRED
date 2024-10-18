<?php

namespace App\Controllers;

use App\Models\CuotaModel; // Asegúrate de que este modelo existe
use App\Models\UnidadesResidencialesModel;

class Cuota extends BaseController
{
    protected $cuotaModel;
    protected $unidadesResidencialesModel;

    public function __construct()
    {
        $this->cuotaModel = new CuotaModel();
        $this->unidadesResidencialesModel = new UnidadesResidencialesModel();
    }

    public function create()
    {
        $usuarioId = $this->request->getPost('usuario_id');

        // Obtén la unidad residencial asociada al usuario
        $unidad = $this->unidadesResidencialesModel->getByUserId($usuarioId);

        if (!$unidad) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'El usuario no tiene una unidad residencial asociada.']);
        }

        // Verifica si ya existe una cuota para el mes actual
        $fechaMes = date('Y-m-01'); // Primer día del mes actual
        if ($this->cuotaModel->cuotaExistente($unidad['ID'], $fechaMes)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Ya existe una cuota generada para este mes.']);
        }

        // Preparar datos de la nueva cuota
        $data = [
            'FECHA_MES' => $fechaMes,
            'ESTADO' => 'Pendiente',
            'VALOR' => $unidad['VALOR_CUOTA'],
            'NO_APTO' => $unidad['NO_APARTAMENTO'],
            'FECHA_PAGO' => null, // Inicialmente no hay fecha de pago
            'UNIDAD_RESIDENCIAL_ID' => $unidad['ID'],
            'USUARIO_ID' => $usuarioId,
        ];

        // Insertar cuota
        if ($this->cuotaModel->insert($data)) {
            return $this->response->setStatusCode(201)->setJSON(['message' => 'Cuota creada con éxito']);
        } else {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Error al crear la cuota']);
        }
    }

    public function show($id)
    {
        $cuota = $this->cuotaModel->find($id); // Asumiendo que 'find' es un método en tu modelo

        if ($cuota) {
            return $this->response->setJSON($cuota);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Cuota no encontrada']);
        }
    }

    public function update($id)
    {
        $data = $this->request->getRawInput();

        if ($this->cuotaModel->update($id, $data)) {
            return $this->response->setStatusCode(200)->setJSON(['message' => 'Cuota actualizada con éxito']);
        } else {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Error al actualizar la cuota']);
        }
    }

    // Método para mostrar la unidad residencial asociada a una cuota
    public function getUnidadResidencial($id)
    {
        // Obtener la cuota por ID
        $cuota = $this->cuotaModel->find($id);

        if (!$cuota) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Cuota no encontrada']);
        }

        // Obtener la unidad residencial usando el UNIDAD_RESIDENCIAL_ID de la cuota
        $unidad = $this->unidadesResidencialesModel->getById($cuota['UNIDAD_RESIDENCIAL_ID']);

        if ($unidad) {
            return $this->response->setJSON($unidad);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Unidad residencial no encontrada']);
        }
    }

    // Nueva función para obtener cuotas por usuario
    public function showByUser($usuarioId)
    {
        $cuotas = $this->cuotaModel->getCuotasByUserId($usuarioId);

        if ($cuotas) {
            return $this->response->setJSON($cuotas);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No se encontraron cuotas para el usuario.']);
        }
    }

    public function delete($id)
    {
        if ($this->cuotaModel->delete($id)) {
            return $this->response->setStatusCode(200)->setJSON(['message' => 'Cuota eliminada con éxito']);
        } else {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Error al eliminar la cuota']);
        }
    }

    // Método para obtener todas las cuotas
    public function index()
    {
        $cuotas = $this->cuotaModel->findAll();

        if ($cuotas) {
            return $this->response->setJSON($cuotas);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No se encontraron cuotas.']);
        }
    }
}
