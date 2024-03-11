<?php
require_once("../../config/app.php");
require_once("../views/inc/session_star.php");
require_once("../../autoload.php");
use app\controllers\userController;
 if (isset($_POST['modulo_usuario'])) {
    $insuario= new userController();
    if ($_POST['modulo_usuario']=="registrar") {
        echo $insuario->registrarUsuarioControlador();
        
    } else {
        
    }
    
   
 } else {
    session_destroy();
    header("Location: ".APP_URL."login/");
    
 }
 
