<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController {
   public static function login(Router $router) {
      $alertas = [];

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $auth = new Usuario($_POST);
         $alertas = $auth->validarLogin();

         if (empty($alertas)) {
            // Comprobar si existe el usuario
            $usuario = Usuario::where('email', $auth->email);

            if ($usuario) {
               // Verificar el password
               if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                  session_start();
                  $_SESSION['usuario'] = $usuario->id;
                  $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                  $_SESSION['email'] = $usuario->email;
                  $_SESSION['login'] = true;

                  // Redireccionar
                  if ($usuario->admin === "1") {
                     $_SESSION['admin'] = $usuario->admin ?? null;
                     header('Location: /admin');
                     exit;
                  } else {
                     header('Location: /cita');
                     exit;
                  }
               } else {
                  Usuario::setAlerta('error', 'Contraseña incorrecta');
               }
            } else {
               Usuario::setAlerta('error', 'Usuario no encontrado');
            }
         }
      }

      $alertas = Usuario::getAlertas();

      $router->render('auth/login', [
         'alertas' => $alertas
      ]);
   }

   public static function logout() {
      echo "Desde logout";
   }

   public static function olvide(Router $router) {
      $alertas = [];

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $auth = new Usuario($_POST);
         $alertas = $auth->validarEmail();

         if (empty($alertas)) {
            $usuario = Usuario::where('email', $auth->email);

            if ($usuario && $usuario->confirmado === "1") {
               // Generar un token
               $usuario->crearToken();
               $usuario->guardar();

               //Enviar el email
               $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
               $email->enviarInstrucciones();

               //Alerta de exito
               Usuario::setAlerta('exito', 'Revisa tu email');

               header('Location: /mensaje');
               exit;
            } else {
               Usuario::setAlerta('error', 'Usuario no encontrado');
            }
         }
      }

      $alertas = Usuario::getAlertas();

      $router->render('auth/olvide-password', [
         'alertas' => $alertas
      ]);
   }


   public static function recuperar(Router $router) {
      $alertas = [];
      $error = false;

      $token = s($_GET['token']);

      //Buscar usuario por token
      $usuario = Usuario::where('token', $token);

      if (empty($usuario)) {
         Usuario::setAlerta('error', 'Token no válido');
         $error = true;
      }

      if($_SERVER['REQUEST_METHOD'] === 'POST') {
         //Leer el nuevo password y guardarlo en la base de datos
         $password = new Usuario($_POST);
         $alertas = $password->validarPassword();

         if(empty($alertas)) {
            $usuario->password = null;
            $usuario->password = $password->password;
            $usuario->hashPassword();
            $usuario->token = null;

            $resultado = $usuario->guardar();   

            if($resultado) {
               header('Location: /');
               Usuario::setAlerta('exito', 'Password actualizado correctamente');
               
               
            }
         }
      }
      $alertas = Usuario::getAlertas();
      $router->render('auth/recuperar-password', [
         'alertas' => $alertas,
         'error' => $error
      ]);
   }

   public static function crear(Router $router) {
      $usuario = new Usuario();
      $alertas = [];

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $usuario->sincronizar($_POST);
         $alertas = $usuario->validarNuevaCuenta();

         if (empty($alertas)) {
            $resultado = $usuario->existeUsuario();

            if ($resultado->num_rows) {
               $alertas = Usuario::getAlertas();
            } else {
               // Hashear el password
               $usuario->hashPassword();

               // Generar un token único
               $usuario->crearToken();

               // Enviar el email
               $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
               $email->enviarConfirmacion();

               // Crear el usuario
               $resultado = $usuario->guardar();
               if ($resultado) {
                  header('Location: /mensaje');
                  exit;
               }
            }
         }
      }

      $router->render('auth/crear-cuenta', [
         'usuario' => $usuario,
         'alertas' => $alertas
      ]);
   }

   public static function mensaje(Router $router) {
      $router->render('auth/mensaje');
   }

   public static function confirmar(Router $router) {
      $alertas = [];
      $token = s($_GET['token']);

      $usuario = Usuario::where('token', $token);

      if (empty($usuario)) {
         Usuario::setAlerta('error', 'Token no válido');
      } else {
         $usuario->confirmado = "1";
         $usuario->token = null;
         $usuario->guardar();
         Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
      }

      $alertas = Usuario::getAlertas();
      $router->render('auth/confirmar-cuenta', [
         'alertas' => $alertas
      ]);
   }
}
