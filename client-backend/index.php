<?php
// SE DEFINEN LOS HEADERS
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');
header('Content-Type: application/json');

class Api
{

    // Configuracion de cliente

    protected $apiUrl = 'http://localhost:8000/api';
    protected $clientDomain = 'localhost'; // Sin http o https
    protected $domainPath = '/';
    protected $useHttps = false;
    protected $sessionCookieName = 'Laqul';
    protected $clientId = '71d4f8ea-1138-11e8-a472-002163944a0x';
    protected $clientSecret = 'y1d4f8ea113811e8a472002163944a0x1234';

    /*********************************************************/

    // Parametros de la clase

    protected $requestMethod;
    protected $apiCommand;
    protected $requestData;

    // Inicializacion de clase
    public function __construct()
    {
        header('Access-Control-Allow-Origin: ' . (($this->useHttps) ? 'https://' : 'http://') . $this->clientDomain);
        $this->requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        $this->process();
    }

    // Procesa la solicitud

    private function process()
    {
        // Primero valida que exista el comando en la solicitud
        if (!filter_has_var(INPUT_GET, 'command')) {
            $this->makeResponse(['error' => 'Missing command'], 400);
        }

        // Se obtiene el comando
        $this->apiCommand = filter_input(INPUT_GET, 'command');

        // En todas las operaciones de escritura se revisa el XSRF-TOKEN
        if (in_array($this->requestMethod, ['POST','PUT','PATCH','DELETE'])) {
            $this->csrf();
            // Se obtienen los parametros de la peticion
            $this->requestData = $this->jsonData();
        }

        // el proceso pasa al metodo runCommand
        return $this->runCommand();
    }

    // Ejecuta un comando
    private function runCommand()
    {
        switch ($this->apiCommand) {
            case 'xsrf':
                $this->xsrf();
                break;
            case 'emailVerification':
                $this->emailVerification();
                break;
            case 'registration':
                $this->registration();
                break;
            case 'login':
                $this->login();
                break;
            case 'loginFacebook':
                $this->socialLink('facebook');
                break;
            case 'loginGoogle':
                $this->socialLink('google');
                break;
            case 'socialLogin':
                $this->socialLogin();
                break;
            case 'forgotPassword':
                $this->forgotPassword();
                break;
            case 'resetPassword':
                $this->resetPassword();
                break;
            case 'logout':
                $this->logout();
                break;
            case 'refreshTokens':
                $this->refreshTokens();
                break;
            default:
                $this->makeResponse(['error' => 'Bad command'], 400);
                break;
        }
    }

    // Retorna una respuesta al cliente
    private function makeResponse($data, $status_code)
    {
        if (is_object($data)) {
            $data->backend = true;
        } else {
            $data['backend'] = true;
        }
        http_response_code($status_code);
        setcookie('XSRF-TOKEN', $this->generateRandomString(150), time() + (120*60), $this->domainPath, $this->clientDomain, $this->useHttps, false);
        print(json_encode($data));
        exit();
    }

    // Genera cadenas de texto al azar
    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Se verifica la cookie XSRF-TOKEN
    private function csrf()
    {
        $headers = getallheaders();
        if (!isset($headers['x-xsrf-token'])) {
            $this->makeResponse(['error' => 'X-XSRF-TOKEN header not exists'], 400);
        }
        if ($headers['x-xsrf-token'] != filter_input(INPUT_COOKIE, 'XSRF-TOKEN')) {
            $this->makeResponse(['error' => 'XSRF-TOKEN mismatch'], 400);
        }
    }

    //OBTIENE LOS DATOS DE LA SOLICITUD
    private function jsonData()
    {
        $data = $this->isValidJSON(file_get_contents('php://input'));
        return $data;
    }

    // VALIDA QUE SEA UNA CADENA JSON VALIDA
    private function isValidJSON($str)
    {
        if ($str == null) {
            return null;
        }
        $data = json_decode($str);
        if (json_last_error() != JSON_ERROR_NONE) {
            $this->makeResponse(['error' => 'Json invalid format'], 400);
        }
        return $data;
    }

    // Realiza una pericion http a la api
    private function httpRequest($path, $method, $body = false)
    {
        $headers = ['X-Requested-With: XMLHttpRequest', 'Content-Type: application/json', 'Accept: application/json'];
        $ch = curl_init($this->apiUrl . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($body) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            $headers[] = 'Content-Length: ' . strlen($body);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            $this->makeResponse(['error' => curl_error($ch)], $status ?: 500);
        }
        curl_close($ch);
        $data = $this->isValidJSON($response);
        return ['status' => $status, 'response' => $data, 'json' => $response];
    }

    // SE ELIMINA LA COOKIE DE SESION
    private function deleteCookie()
    {
        if (isset($_COOKIE[$this->sessionCookieName])) {
            unset($_COOKIE[$this->sessionCookieName]);
            setcookie($this->sessionCookieName, '', time() - 3600, $this->domainPath, $this->clientDomain, $this->useHttps, true);
        }
    }

    /***********************COMANDOS **************************/
    /**********************************************************/
    
    // Inicializa la cookie xsrf
    private function xsrf()
    {
        $this->makeResponse(['success' => true], 200);
    }

    // Obtiene un codigo de verificacion de email para proceder con el registro del usuario
    private function emailVerification()
    {
        if (!isset($this->requestData->email)) {
            $this->makeResponse(['error' => 'Missing params'], 400);
        }
        $json = json_encode([
          'client_id' => $this->clientId,
          'email' => $this->requestData->email
        ]);
        $data = $this->httpRequest('/auth/verification', 'POST', $json);
        if ($data['status'] == 200 && isset($data['response']->code)) {
            $this->makeResponse(['success' => true], $data['status']);
        }
        $this->makeResponse($data['response'], $data['status']);
    }

    // Registro de usuarios
    private function registration()
    {
        if (!isset($this->requestData->code) || !isset($this->requestData->name) || !isset($this->requestData->password) || !isset($this->requestData->password_confirmation) || !isset($this->requestData->timezone)) {
            $this->makeResponse(['error' => 'Missing params'], 400);
        }
        $json = json_encode([
          'client_id' => $this->clientId,
          'code' => $this->requestData->code,
          'name' => $this->requestData->name,
          'password' => $this->requestData->password,
          'password_confirmation' => $this->requestData->password_confirmation,
          'timezone' => $this->requestData->timezone
        ]);
        $data = $this->httpRequest('/auth/registration', 'POST', $json);
        if ($data['status'] == 200 && isset($data['response']->name)) {
            $this->makeResponse($data['response'], $data['status']);
        }
        $this->makeResponse($data['response'], $data['status']);
    }

    // Inicia el proceso de login
    private function login()
    {
        if (!isset($this->requestData->username) || !isset($this->requestData->password)) {
            $this->makeResponse(['error' => 'Missing params'], 400);
        }
        $json = json_encode([
          'client_id' => $this->clientId,
          'client_secret' => $this->clientSecret,
          'grant_type'   => 'password',
          'username' => $this->requestData->username,
          'password' => $this->requestData->password
        ]);
        $data = $this->httpRequest('/auth/token', 'POST', $json);
        if ($data['status'] == 200 && isset($data['response']->access_token)) {
            setcookie($this->sessionCookieName, $data['response']->refresh_token, time() + 15552000, $this->domainPath, $this->clientDomain, $this->useHttps, true);
            $response = ['access_token' => $data['response']->access_token, 'expires_in' => $data['response']->expires_in];
            if (isset($data['response']->firebase_token)) {
                $response['firebase_access_token'] = $data['response']->firebase_token;
            }
            $this->makeResponse($response, $data['status']);
        }
        $this->makeResponse($data['response'], $data['status']);
    }

    // Obtiene el link de redireccion de la red social
    private function socialLink($platform)
    {
        $data = $this->httpRequest('/auth/social/' . $platform, 'GET');
        if ($data['status'] == 200 && isset($data['response']->redirect)) {
            $this->makeResponse($data['response'], $data['status']);
        }
        $this->makeResponse($data['response'], $data['status']);
    }

    // Inicia el proceso de login social
    private function socialLogin()
    {
        if (!isset($this->requestData->code) || !isset($this->requestData->platform) || !isset($this->requestData->timezone)) {
            $this->makeResponse(['error' => 'Missing params'], 400);
        }
        $json = json_encode([
          'client_id' => $this->clientId,
          'client_secret' => $this->clientSecret,
          'code' => $this->requestData->code,
          'timezone' => $this->requestData->timezone
        ]);
        $data = $this->httpRequest('/auth/social/' . $this->requestData->platform, 'POST', $json);
        if ($data['status'] == 200 && isset($data['response']->access_token)) {
            setcookie($this->sessionCookieName, $data['response']->refresh_token, time() + 15552000, $this->domainPath, $this->clientDomain, $this->useHttps, true);
            $response = ['access_token' => $data['response']->access_token, 'expires_in' => $data['response']->expires_in];
            if (isset($data['response']->firebase_token)) {
                $response['firebase_access_token'] = $data['response']->firebase_token;
            }
            $this->makeResponse($response, $data['status']);
        }
        $this->makeResponse($data['response'], $data['status']);
    }

    // Obtiene un token para restablecer la contrasena del usuario
    private function forgotPassword()
    {
        if (!isset($this->requestData->email)) {
            $this->makeResponse(['error' => 'Missing params'], 400);
        }
        $json = json_encode([
          'client_id' => $this->clientId,
          'email' => $this->requestData->email
        ]);
        $data = $this->httpRequest('/auth/forgot', 'POST', $json);
        if ($data['status'] == 200 && isset($data['response']->token)) {
            $this->makeResponse(['success' => true], $data['status']);
        }
        $this->makeResponse($data['response'], $data['status']);
    }

    // Restablecimiento de password
    private function resetPassword()
    {
        if (!isset($this->requestData->token) || !isset($this->requestData->password) || !isset($this->requestData->password_confirmation)) {
            $this->makeResponse(['error' => 'Missing params'], 400);
        }
        $json = json_encode([
          'client_id' => $this->clientId,
          'token' => $this->requestData->token,
          'password' => $this->requestData->password,
          'password_confirmation' => $this->requestData->password_confirmation
        ]);
        $data = $this->httpRequest('/auth/reset', 'PATCH', $json);
        if ($data['status'] == 200 && isset($data['response']->success)) {
            $this->makeResponse($data['response'], $data['status']);
        }
        $this->makeResponse($data['response'], $data['status']);
    }

    // Cierra la sesion del usuario
    private function logout($data = ['success' => true], $status = 200)
    {
        $this->deleteCookie();
        $this->makeResponse($data, $status);
    }

    // Inicia el proceso de renovacion de token
    private function refreshTokens()
    {
        if (!isset($_COOKIE[$this->sessionCookieName])) {
            $this->makeResponse(['error' => 'Session dont exists'], 401);
        }
        $json = json_encode([
          'client_id' => $this->clientId,
          'client_secret' => $this->clientSecret,
          'grant_type'   => 'refresh_token',
          'refresh_token' => filter_input(INPUT_COOKIE, $this->sessionCookieName)
        ]);
        $data = $this->httpRequest('/auth/token', 'POST', $json);
        if ($data['status'] == 200 && isset($data['response']->access_token)) {
            setcookie($this->sessionCookieName, $data['response']->refresh_token, time() + 15552000, $this->domainPath, $this->clientDomain, $this->useHttps, true);
            $response = ['access_token' => $data['response']->access_token, 'expires_in' => $data['response']->expires_in];
            if (isset($data['response']->firebase_token)) {
                $response['firebase_access_token'] = $data['response']->firebase_token;
            }
            $this->makeResponse($response, $data['status']);
        }
        $this->logout($data['response'], $data['status']);
    }
}
$request = new Api;
