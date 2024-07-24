<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class PruebaController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        // Obtener el JSON enviado en la solicitud
        $data = $this->request->getJSON();

        // Verificar si el JSON es válido
        if ($data === null) {
            return $this->respond([
                'status' => false,
                'message' => 'Failed to parse JSON string.',
                'data' => []
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Responder con éxito
        return $this->respond([
            'status' => true,
            'message' => 'Request processed successfully.',
            'data' => $info
        ]);
    }
}
