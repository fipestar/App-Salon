<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController{
   public static function login(Router $router){
      $alertas = [];

      if($_SERVER['REQUEST_METHOD'] === 'POST'){

          $auth = new Usuario($_POST);
       
         $alertas = $auth->validarLogin();

         if(empty($alertas)){
            //Comprobar si existe el usuario
            $usuario = Usuario::where('email', $auth->email);

            if($usuario){
               //Verificar el passwrod
               if($usuario->comprobarPasswordAndVerificado($auth->password)){
                  
               } 
            }else{
               Usuario::setAlerta('error', 'Usuario no encontrado');
            }
         }
      }

      $alertas = Usuario::getAlertas();

     $router->render('auth/login', [
      'alertas' => $alertas
     ]);
   }

   public static function logout(){
    echo "Desde logout";
   }

   public static function olvide(Router $router){
    $router->render('auth/olvide-password', [
      
    ]);
   }

   public static function recuperar(){
    echo "Desde recuperar";
   }

   public static function crear(Router $router){

    $usuario = new Usuario();

    //Alertas vacias
    $alertas = [];
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      
        $usuario->sincronizar($_POST);
        $alertas = $usuario->validarNuevaCuenta();

        //Revisar que alertas este vacio
        if(empty($alertas)){
           $resultado = $usuario->existeUsuario();

           if($resultado->num_rows){
            $alertas = Usuario::getAlertas();
           }else{
            //Hashear el password
            $usuario->hashPassword();

            //Generar un token unico
            $usuario->crearToken();

            //Enviar el email
            $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
            $email->enviarConfirmacion();

            //Crear el usuario
            $resultado = $usuario->guardar();
            if($resultado){
               header('Location: /mensaje');
            }

           }
        }
    }
    $router->render('auth/crear-cuenta', [
          'usuario' => $usuario,
          'alertas' => $alertas
    ]);
   }

   public static function mensaje(Router $router){
         $router->render('auth/mensaje');
   }

   public static function confirmar(Router $router){

      $alertas = [];

      $token = s($_GET['token']);

      $usuario = Usuario::where('token', $token);

      if(empty($usuario)){
         //Mostrar mensaje de error
         Usuario::setAlerta('error', 'Token no valido');
      }else{
         //Modificar a usuario confirmado

         $usuario->confirmado = "1";
         $usuario->token = null;
         $usuario->guardar();
         Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
      }

      //Obtener alertas
      $alertas = Usuario::getAlertas();
      //Renderizar la vista
      $router->render('auth/confirmar-cuenta', [
         'alertas' => $alertas
      ]);
   }
}