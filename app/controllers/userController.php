<?php
namespace app\controllers;
 use app\models\mainModel;
 class userController extends mainModel {
    public function registrarUsuarioControlador(){
      #almacenar datos#
      $nombre=$this->limpiarCadena($_POST['usuario_nombre']);
      $apellido=$this->limpiarCadena($_POST['usuario_apellido']);
      $usuario=$this->limpiarCadena($_POST['usuario_usuario']);
      $email=$this->limpiarCadena($_POST['usuario_email']);
      $clave1=$this->limpiarCadena($_POST['usuario_clave_1']);
      $clave2=$this->limpiarCadena($_POST['usuario_clave_2']);
      #Verificar Datos#
      if ($nombre == "" || $apellido == "" || $usuario == ""  || $clave1 == "" || $clave2 == "") {
           $alerta = ["tipo"=>"simple",
                      "titulo"=>"Ocurrior un error inesperado", 
                      "texto"=>"No has llenado todo los datos",
                      "icono"=>"error"];
                       return json_encode($alerta);
                       exit();
      }
      #Verificar Integridad Datos#
      if ($this->validarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)) {
         $alerta = ["tipo"=>"simple",
                      "titulo"=>"Ocurrior un error inesperado", 
                      "texto"=>"El nombre no cumple los caracteres especificados",
                      "icono"=>"error"];
                       return json_encode($alerta);
                       exit();
      }
      if ($this->validarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)) {
         $alerta = ["tipo"=>"simple",
                      "titulo"=>"Ocurrior un error inesperado", 
                      "texto"=>"El apellido no cumple los caracteres especificados",
                      "icono"=>"error"];
                       return json_encode($alerta);
                       exit();
      }
      if ($this->validarDatos("[a-zA-Z0-9]{4,20}",$usuario)) {
         $alerta = ["tipo"=>"simple",
                      "titulo"=>"Ocurrior un error inesperado", 
                      "texto"=>"El usuario no cumple los caracteres especificados",
                      "icono"=>"error"];
                       return json_encode($alerta);
                       exit();
      }
      if ($this->validarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || $this->validarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave2)) {
         $alerta = ["tipo"=>"simple",
                      "titulo"=>"Ocurrior un error inesperado", 
                      "texto"=>"La clave no cumple los caracteres especificados",
                      "icono"=>"error"];
                       return json_encode($alerta);
                       exit();
      }
      #Verificando email#
      if ($email != "") {
           if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $check_email=$this->ejecutarConsulta("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
            if ($check_email->rowCount()>0) {  
               $alerta = ["tipo"=>"simple",
               "titulo"=>"Ocurrior un error inesperado", 
               "texto"=>"El email ya se encuentra en uso",
               "icono"=>"error"];
                return json_encode($alerta);
                exit(); }
            $check_email=null;
           
           } else {
             $alerta = ["tipo"=>"simple",
                      "titulo"=>"Ocurrior un error inesperado", 
                      "texto"=>"El email no cumple los caracteres especificados",
                      "icono"=>"error"];
                       return json_encode($alerta);
                       exit();
           }
         
      }
      #Verificando clave#
      if( $clave1 != $clave2){
         $alerta = ["tipo"=>"simple",
         "titulo"=>"Ocurrior un error inesperado", 
         "texto"=>"Las claves no coinciden",
         "icono"=>"error"];
          return json_encode($alerta);
          exit();

      }else{
         $clave=password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
      }
       #Verificando usuario#
         $check_usuario=$this->ejecutarConsulta("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
            if ($check_usuario->rowCount()>0) {  
               $alerta = ["tipo"=>"simple",
               "titulo"=>"Ocurrior un error inesperado", 
               "texto"=>"El Usuario ya se encuentra en uso",
               "icono"=>"error"];
                return json_encode($alerta);
                exit(); }
            $check_usuario=null;
    }
    
 }