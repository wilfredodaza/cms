<?php


namespace App\Controllers;


use App\Models\User;
use Config\Services;
use App\Models\Plantilla;
use App\Models\Password;
use CodeIgniter\API\ResponseTrait;


class AuthController extends BaseController
{
    use ResponseTrait;
    
    public function login()
    {
        return view('auth/login');
    }

    public function validation()
    {

        $errors = $this->validate([
            'username' => 'required|min_length[4]',
            'password' => 'required|min_length[8]|max_length[20]'
        ]);

        if ($errors) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $captcha = $this->request->getPost('g-recaptcha-response');
            $validationCaptcha = ValidateReCaptcha($captcha);
            if($validationCaptcha){
                $user = new User();
                $data = $user
                    ->select(['users.*', 'roles.name as role_name'])
                    ->join('roles', 'roles.id = users.role_id')
                    ->where('username', $username)->first();
                if ($data) {
                    if ($data->status == 'active') {
                        $data->password = $user->getPassword($data->id);
                        if((int) $data->password->attempts < 5){
                            if (password_verify($password, $data->password->password)) {
                                $session = session();
                                $session->set('user', $data);
                                return redirect()->to(base_url(['dashboard']));
                            } else {
                                $p_model = new Password();
                                $p_model->save([
                                    'id'        => $data->password->id,
                                    'attempts'  => (int) $data->password->attempts + 1
                                ]);
                                return redirect()->to(base_url(['login']))->with('errors', "Las credenciales no concuerdan. Numeros de intentos restantes <b>".(4 - $data->password->attempts)."</b>");
                            }
                        }else{
                            return redirect()->to(base_url(['login']))->with('errors', 'Limite de intentos superados.');
                        }
                    } else {
                        return redirect()->to(base_url(['login']))->with('errors', 'La cuenta no se encuentra activa.');
                    }
                } else {
                    return redirect()->to(base_url(['login']))->with('errors', 'Las credenciales no concuerdan.');
                }
            }else {
                return redirect()->to(base_url(['login']))->with('errors', 'Error al validar el Captcha');
            }
        } else {
            return redirect()->to(base_url(['login']))->with('errors', 'Las credenciales no concuerdan.');
        }


    }

    public function register()
    {
        $validation = Services::validation();
        return view('auth/register', ['validation' => $validation]);
    }

    public function create()
    {
        if ($this->validate([
            'name'      => 'required|max_length[45]',
            'username'  => 'required|is_unique[users.username]|max_length[40]',
            'email'     => 'required|valid_email|is_unique[users.email]|max_length[100]',
            'password'  => 'required|min_length[8]|max_length[20]'
        ], [
            'name' => [
                'required' => 'El campo Nombres y Apellidos es obrigatorio.',
                'max_length' => 'El campo Nombres Y Apellidos no debe terner mas de 45 caracteres.'
            ],
            'username' => [
                'required' => 'El campo Nombre de Usuario es obligatorio',
                'is_username' => 'Lo sentimos. El nombre de usuario ya se encuntra registrado.',
                'max_length' => 'El campo Nombre de Usuario no puede superar mas de 20 caracteres.'
            ],
            'email' => [
                'required' => 'El campo Correo Electronico es obrigatorio.',
                'is_unique' => 'Lo sentimos. El correo ya se encuntra registrado.'
            ],
            'password' => [
                'required' => 'El campo Contraseña es obligatorio.',
                'min_length' => 'El campo Contraseña debe tener minimo 8 caracteres.',
                'max_length' => 'El campo Contraseña no debe tener mas de 20 caracteres.'
            ]

        ])) {
            $data = [
                'name' => $this->request->getPost('name'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                // 'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'status' => 'inactive',
                'role_id' => 2
            ];

            $u_model = new User();
            $u_model->save($data);

            $user_id = $u_model->insertID();
            $p_model = new Password();
            $p_model->save([
                'user_id'   => $user_id,
                'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
            ]);
            return redirect()->to(base_url(['login']))->with('success', 'Usuario creado exitosamente.');
        } else {
            return redirect()->to(base_url().'/register')->withInput();
        }


    }

    public function resetPassword()
    {
        return view('auth\reset_password');
    }

    public function forgotPassword()
    {
        $request = Services::request();
        $user = new User();
        $data = $user->where('email', $request->getPost('email'))->get()->getResult();
        if (count($data) > 0) {
            $email = new EmailController();
            $password = $this->encript();
            // $user->set(['password' => password_hash($password, PASSWORD_DEFAULT)]);
            // $user->where('id', $data[0]->id);
            // $user->update();
            $response = $email->send('wabox324@gmail.com', 'wabox', $request->getPost('email'), 'Recuperacion de contraseña', password($password));
            // var_dump($response); die;
            return redirect()->to(base_url(['reset_password']))
                ->with($response->status ? 'success' : 'danger', $response->message);
        } else {
            return redirect()->to(base_url(['reset_password']))
                ->with('danger', 'Las credenciales no coinciden con los datos ingresados.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url(['login']));
    }

    public function encript($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
