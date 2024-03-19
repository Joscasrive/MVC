<?php
require_once("../../config/app.php");
require_once("../views/inc/session_star.php");
require_once("../../autoload.php");
use app\controllers\userController;
 if (isset($_POST['modulo_usuario'])) {
    $insuario= new userController();
    if ($_POST['modulo_usuario']=="registrar") {
        echo $insuario->registrarUsuarioControlador();
        }
        if ($_POST['modulo_usuario'] =="eliminar"){
         echo $insuario->eliminarUsuarioControlador();
        }
        if ($_POST['modulo_usuario'] =="actualizar"){
         echo $insuario->actualizarUsuario();
        }
    
 } else {
    session_destroy();
    header("Location: ".APP_URL."login/");
    
 }
 
 