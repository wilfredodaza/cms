<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use Config\Services;

use App\Models\Password;

class PasswordController extends BaseController
{

    public function index(){
        $fechaEspecifica = new \DateTime(session('user')->password->created_at);
        return view('password/index', [
        ]);
    }

    public function updated(){
        $validation = Services::validation();

        if($this->validate([
            'password_now'      => 'required',
            'password'          => 'required|min_length[6]',
            'password_confirm'  => 'required|matches[password]',
        ], [
            'password_now' => [
                'required'      => 'El campo Contraseña actual es obligatoria.'
            ],
            'password' => [
                'required'      => 'El campo Contraseña es obligatorio.',
                'min_length'    => 'El campo Contraseña debe tener minimo 6 caracteres.'
            ],
            'password_confirm' => [
                'required'      => 'La confirmacion de la contraseña es obligatoria.',
                'matches'       => 'Las contraseñas no coinciden.'
            ]
        ])){
            $newPassword = $this->request->getPost('password');
            $nowPassword = $this->request->getPost('password_now');
            if(password_verify($nowPassword, session('user')->password->password)){
                $info = $this->change_password($newPassword);
                return redirect()->to(base_url(['password']))->with($info->status ? 'success' : 'errors', $info->message);
            }
            return redirect()->to(base_url(['password']))->with('errors', 'La contraseña no concuerda');
        }else{
            $errors = implode("<br>", $validation->getErrors());
            return redirect()->to(base_url(['password']))->with('errors', $errors);
        }
    }

    protected function change_password($newPassword){

        $userId = session('user')->id;

        if(!(bool) preg_match('/[A-Z]/', $newPassword)){ // Validacion para que tenga una letra mayuscula
            return (object) [
                'status'    => false,
                'message'   => 'La Contraseña debe contener al menos una letra mayúscula.'
            ];
        }else if(!(bool) preg_match('/[a-z]/', $newPassword)){ // Validacion para que tenga una letra minuscula
            return (object) [
                'status'    => false,
                'message'   => 'La Contraseña debe contener al menos una letra minúscula.'
            ];
        }else if(!(bool) preg_match('/[^a-zA-Z\d]/', $newPassword)){ // Validacion para que tenga un caracter diferente a letra o numero
            return (object) [
                'status'    => false,
                'message'   => 'La Contraseña debe contener al menos un carácter especial diferente a una letra o número.'
            ];
        }else if(!(bool) preg_match('/\d/', $newPassword)){
            return (object) [
                'status'    => false,
                'message'   => 'La Contraseña debe contener al menos un número.'
            ];
        }

        $p_model = new Password();
        $oldPasswords = $p_model->where(['user_id' => $userId])->orderBy('id', 'DESC')->limit(5)->get()->getResult();

        foreach ($oldPasswords as $oldPassword) {
            if (password_verify($newPassword, $oldPassword->password)) {
                return (object) [
                    'status'    => false,
                    'message'   => 'La contraseña debe de ser diferente a las ultimas 5 utilizadas.'
                ];
            }
        }

        // Marcar las contraseñas anteriores como inactivas
        $p_model->where(['user_id' => $userId])->set(['status' => 'inactive'])->update();

        // Guardar la nueva contraseña como activa
        $p_model->save([
            'user_id' => $userId,
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        // Actualizar la contraseña en la sesión del usuario
        $password = $p_model->where(['user_id' => $userId, 'status' => 'active'])->first();
        session('user')->password = $password;
        return (object) [
            'status'    => true,
            'message'   => 'Contraseña renovada'
        ];
    }
}
