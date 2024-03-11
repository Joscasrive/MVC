<?php
namespace app\models;

class viewsModel{
    protected function obtenerVistasModelos($vista){
        $listaBlanca=["inicio","userNew","userList","userSearch","userUpdate","userPhoto","logOut"];
        if (in_array($vista , $listaBlanca)){
            if (is_file("./app/views/content/".$vista."-view.php")) {
                $contenido ="./app/views/content/".$vista."-view.php";
                
            } else {
                $contenido ="404";
                
            }
            
            
        }else if ($vista =="login"|| $vista =="index"){
            $contenido="login";
        }else{
            $contenido="404";
        }
return $contenido;
    }


}
