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
                exit(); 
               }
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
        
      #Directorio de imagenes#

      $img_dir="../views/fotos/";
   
   
      #Comprobar seleccion de imagenes#
      if ($_FILES['usuario_foto']['name'] !="" && $_FILES['usuario_foto']['size'] != 0  ) {
         #Crear directorio de imagenes#
         if(!file_exists($img_dir)){
            if(!mkdir($img_dir,0777)){
               $alerta = ["tipo"=>"simple",
               "titulo"=>"Ocurrior un error inesperado", 
               "texto"=>"No se puedo crear el direcctorio de img",
               "icono"=>"error"];
                return json_encode($alerta);
                exit();
            }
         }
          #Comprobar Formato de imagenes#
        if (mime_content_type($_FILES['usuario_foto']['tmp_name'])!= "image/jpeg" &&  mime_content_type($_FILES['usuario_foto']['tmp_name']) != "image/png") {
         $alerta = ["tipo"=>"simple",
               "titulo"=>"Ocurrior un error inesperado", 
               "texto"=>"El formato de img no es correcto",
               "icono"=>"error"];
                return json_encode($alerta);
                exit();
        }
        #Verificar el peso de imagenes#
        if ($_FILES['usuario_foto']['size'] /1024 > 5120 ) {
         $alerta = ["tipo"=>"simple",
               "titulo"=>"Ocurrior un error inesperado", 
               "texto"=>"El peso de la img supera el limite de 5mb",
               "icono"=>"error"];
                return json_encode($alerta);
                exit();
         
        }
        $foto=str_ireplace(" ","_",$nombre);
        $foto=$foto."_".rand(0,100);
         #Extencion de la imagen#
         switch (mime_content_type($_FILES['usuario_foto']['tmp_name'])) {
            case  "image/jpeg":
                  $foto=$foto.".jpg";
               break;
               case   "image/png":
                  $foto=$foto.".png";
               break;
            }
            chmod($img_dir,0777);
             #Mover imagenen al dir#
             if (!move_uploaded_file($_FILES['usuario_foto']['tmp_name'],$img_dir.$foto)) {
               $alerta = ["tipo"=>"simple",
               "titulo"=>"Ocurrior un error inesperado", 
               "texto"=>"No se puedo mover la img al directorio",
               "icono"=>"error"];
                return json_encode($alerta);
                exit();
             }
         
      } else {
         $foto="";
        
      }
      $usuario_datos_reg=[
         [
            "campo_nombre"=>"usuario_nombre",
            "campo_marcador"=>":nombre",
            "campo_valor"=>$nombre
         ],
         [
            "campo_nombre"=>"usuario_apellido",
            "campo_marcador"=>":apellido",
            "campo_valor"=>$apellido
         ],
         [
            "campo_nombre"=>"usuario_usuario",
            "campo_marcador"=>":usuario",
            "campo_valor"=>$usuario
         ],
         [
            "campo_nombre"=>"usuario_clave",
            "campo_marcador"=>":clave",
            "campo_valor"=>$clave
         ],
         [
            "campo_nombre"=>"usuario_email",
            "campo_marcador"=>":email",
            "campo_valor"=>$email
         ],
         [
            "campo_nombre"=>"usuario_foto",
            "campo_marcador"=>":foto",
            "campo_valor"=>$foto
         ],
         [
            "campo_nombre"=>"usuario_creado",
            "campo_marcador"=>":creado",
            "campo_valor"=>date("Y-m-d H:i:s")
         ],
         [
            "campo_nombre"=>"usuario_actualizado",
            "campo_marcador"=>":actualizado",
            "campo_valor"=>date("Y-m-d H:i:s")
         ],
      ];
      $registrar_usuario=$this->guardarDatos("usuario",$usuario_datos_reg);
      if ($registrar_usuario-> rowCount() == 1) {
         $alerta = ["tipo"=>"limpiar",
               "titulo"=>"Usuario Registrado", 
               "texto"=>"El Usuario ".$nombre." ".$apellido." fue registrado",
               "icono"=>"success"];
                
                
         
      } else {
         if (is_file($img_dir.$foto)) {
            chmod($img_dir.$foto,0777);
            unlink($img_dir.$foto);
            
         }
         $alerta = ["tipo"=>"simple",
               "titulo"=>"Ocurrior un error inesperado", 
               "texto"=>"No se pudo registrar el usuario intente mas tarde",
               "icono"=>"error"];
               
      }
      return json_encode($alerta);
      
   
         }
  
    public function listarUsuarioControlador($pagina,$registro,$url,$busqueda){
      $pagina=$this->limpiarCadena($pagina);
      $registro=$this->limpiarCadena($registro);
      $url=$this->limpiarCadena($url);
      $url=APP_URL.$url."/";
      $busqueda=$this->limpiarCadena($busqueda);
      $tabla = "";
      
      $pagina = (isset($pagina) && $pagina > 0)  ?  (int) $pagina : 1 ; 
      
      $inicio = ($pagina > 0 ) ? (($pagina*$registro)-$registro) :0 ;

      if (isset($busqueda) && $busqueda != "") {

         $consulta_datos = "SELECT * FROM usuario WHERE ((usuario_id !='".$_SESSION['id']."' AND usuario !='1') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio,$registro";
         $consulta_total= "SELECT COUNT(usuario_id) FROM usuario WHERE ((usuario_id !='".$_SESSION['id']."' AND usuario !='1') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%'))";
        
      } else {
         $consulta_datos="SELECT * FROM usuario WHERE usuario_id!='".$_SESSION['id']."' AND usuario_id!='1' ORDER BY usuario_nombre ASC LIMIT $inicio,$registro";
         $consulta_total= "SELECT COUNT(usuario_id) FROM usuario WHERE usuario_id !='".$_SESSION['id']."' AND usuario_id !='1'";
      }

      $datos = $this->ejecutarConsulta($consulta_datos);
      $datos = $datos->fetchAll();
      $total = $this->ejecutarConsulta($consulta_total);
      $total = (int) $total->fetchColumn();
      $numeroPaginas=ceil($total/$registro);
      $tabla .='
      <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th class="has-text-centered">#</th>
                    <th class="has-text-centered">Nombre</th>
                    <th class="has-text-centered">Usuario</th>
                    <th class="has-text-centered">Email</th>
                    <th class="has-text-centered">Creado</th>
                    <th class="has-text-centered">Actualizado</th>
                    <th class="has-text-centered" colspan="3">Opciones</th>
                </tr>
            </thead>
            <tbody>
      ';
      if ($total >=1 && $pagina <=$numeroPaginas) {
         $contador=$inicio+1;
         $pag_inicio=$inicio+1;
         foreach($datos as $filas){
            $tabla.='
            <tr class="has-text-centered">
					<td>'.$contador.'</td>
					<td>'.$filas['usuario_nombre'].' '.$filas['usuario_apellido'].'</td>
					<td>'.$filas['usuario_usuario'].'</td>
					<td>'.$filas['usuario_email'].'</td>
					<td>'.date("d-m-Y h:i:s A",strtotime($filas['usuario_creado'])).'</td>
					<td>'.date("d-m-Y h:i:s A",strtotime($filas['usuario_actualizado'])).'</td>
					<td>
	                    <a href="'.APP_URL.'userPhoto/'.$filas['usuario_id'].'/" class="button is-info is-rounded is-small">Foto</a>
	                </td>
	                <td>
	                    <a href="'.APP_URL.'userUpdate/'.$filas['usuario_id'].'/" class="button is-success is-rounded is-small">Actualizar</a>
	                </td>
	                <td>
	                	<form class="formularioAjax" action="'.APP_URL.'app/ajax/userAjax.php" method="POST" autocomplete="off">

	                		<input type="hidden" name="modulo_usuario" value="eliminar">
	                		<input type="hidden" name="usuario_id" value="'.$filas['usuario_id'].'">

	                    	<button type="submit" class="button is-danger is-rounded is-small">Eliminar</button>
	                    </form>
	                </td>
				</tr>

            ';
            $contador++;

         }
         $pag_final=$contador-1;

        
      } else {
         if ($total>=1) {
            $tabla .='
            <tr class="has-text-centered" >
	                <td colspan="7">
	                    <a href="'.$url.'1/" class="button is-link is-rounded is-small mt-4 mb-4">
	                        Haga clic acá para recargar el listado
	                    </a>
	                </td>
	            </tr>
            
            ';
         } else {
            $tabla .='  
            <tr class="has-text-centered" >
	                <td colspan="7">
	                    No hay registros en el sistema
	                </td>
	            </tr>
               ';
            
         }
         
        
      }
      
      $tabla .='</tbody></table></div>';
      if ($total >=1 && $pagina <=$numeroPaginas) {
         $tabla .='<p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
         $tabla .=$this->paginadorTabla($pagina,$numeroPaginas,$url,15);
         
      }
      return $tabla;
   
   }
      
   public function eliminarUsuarioControlador(){

      $id=$this->limpiarCadena($_POST['usuario_id']);

      if($id==1){
         $alerta=[
            "tipo"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"No podemos eliminar el usuario principal del sistema",
            "icono"=>"error"
         ];
         return json_encode($alerta);
           exit();
      }

      # Verificando usuario #
       $check_usuario=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
       if($check_usuario->rowCount()<=0){
           $alerta=[
            "tipo"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"No hemos encontrado el usuario en el sistema",
            "icono"=>"error"
         ];
         return json_encode($alerta);
           exit();
       }else{
          $check_usuario=$check_usuario->fetch();
       }

       $eliminarUsuario=$this->eliminarRegistro("usuario","usuario_id",$id);

       if($eliminarUsuario->rowCount()==1){

          if(is_file("../views/fotos/".$check_usuario['usuario_foto'])){
               chmod("../views/fotos/".$check_usuario['usuario_foto'],0777);
               unlink("../views/fotos/".$check_usuario['usuario_foto']);
           }

           $alerta=[
            "tipo"=>"recargar",
            "titulo"=>"Usuario eliminado",
            "texto"=>"El usuario ".$check_usuario['usuario_nombre']." ".$check_usuario['usuario_apellido']." ha sido eliminado del sistema correctamente",
            "icono"=>"success"
         ];

       }else{

          $alerta=[
            "tipo"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"No hemos podido eliminar el usuario ".$check_usuario['usuario_nombre']." ".$check_usuario['usuario_apellido']." del sistema, por favor intente nuevamente",
            "icono"=>"error"
         ];
       }

       return json_encode($alerta);
   }
   
   public function actualizarUsuario(){
      $id=$this->limpiarCadena($_POST['usuario_id']);
    
      $adUsuario=$this->limpiarCadena($_POST['administrador_usuario']);
      $adclave=$this->limpiarCadena($_POST['administrador_clave']);

      # Verificando usuario #
      $check_usuario=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
      if($check_usuario->rowCount()<=0){
          $alerta=[
           "tipo"=>"simple",
           "titulo"=>"Ocurrió un error inesperado",
           "texto"=>"No hemos encontrado el usuario en el sistema",
           "icono"=>"error"
        ];
        return json_encode($alerta);
          exit();
      }else{
         $check_usuario=$check_usuario->fetch();
      }

      
      if ( $adUsuario == "" || $adclave == "") {
         $alerta = ["tipo"=>"simple",
                    "titulo"=>"Ocurrior un error inesperado", 
                    "texto"=>"No has llenado todo los campos",
                    "icono"=>"error"];
                     return json_encode($alerta);
                     exit();
    }


       #Verificar Integridad Datos#
       if ($this->validarDatos("[a-zA-Z0-9]{4,20}",$adUsuario)) {
         $alerta = ["tipo"=>"simple",
                      "titulo"=>"Ocurrior un error inesperado", 
                      "texto"=>"El nombre no cumple los caracteres especificados",
                      "icono"=>"error"];
                       return json_encode($alerta);
                       exit();
      }
      if ($this->validarDatos("[a-zA-Z0-9$@.-]{7,100}",$adclave)) {
         $alerta = ["tipo"=>"simple",
                      "titulo"=>"Ocurrior un error inesperado", 
                      "texto"=>"El apellido no cumple los caracteres especificados",
                      "icono"=>"error"];
                       return json_encode($alerta);
                       exit();
      }
      
      # Verificando administrador #

      $check_admin=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_usuario='$adUsuario' AND usuario_id='".$_SESSION['id']."'");
      if($check_admin->rowCount()==1){
       $check_admin=$check_admin->fetch();
       if ($check_admin['usuario_usuario'] != $adUsuario || !password_verify($adclave,$check_admin['usuario_clave']) ) {
        $alerta = ["tipo"=>"simple",
         "titulo"=>"Ocurrior un error inesperado", 
         "texto"=>"La clave de administrador es incorrecta intente de nuevo!",
         "icono"=>"error"];
          return json_encode($alerta);
          exit();
       }
      }else{
         $alerta=[
            "tipo"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"Usuario administrador incorrecto",
            "icono"=>"error"
         ];
         return json_encode($alerta);
           exit();
      }
       #almacenar datos#
       $nombre=$this->limpiarCadena($_POST['usuario_nombre']);
       $apellido=$this->limpiarCadena($_POST['usuario_apellido']);
       $usuario=$this->limpiarCadena($_POST['usuario_usuario']);
       $email=$this->limpiarCadena($_POST['usuario_email']);
       $clave1=$this->limpiarCadena($_POST['usuario_clave_1']);
       $clave2=$this->limpiarCadena($_POST['usuario_clave_2']);
       #Verificar Datos#
       if ($nombre == "" || $apellido == "" || $usuario == "" ) {
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
       
       #Verificando email#
       if ($email != "" &&  $check_usuario['usuario_email'] !=$email) {
            if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
             $check_email=$this->ejecutarConsulta("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
             if ($check_email->rowCount()>0) {  
                $alerta = ["tipo"=>"simple",
                "titulo"=>"Ocurrior un error inesperado", 
                "texto"=>"El email ya se encuentra en uso",
                "icono"=>"error"];
                 return json_encode($alerta);
                 exit(); 
                }
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
       if( $clave1 != "" || $clave2!="" ){

         if ($this->validarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || $this->validarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave2)) {
            $alerta = ["tipo"=>"simple",
                         "titulo"=>"Ocurrior un error inesperado", 
                         "texto"=>"La clave no cumple los caracteres especificados",
                         "icono"=>"error"];
                          return json_encode($alerta);
                          exit();
         }else{
            if ($clave1 != $clave2) {
               $alerta = ["tipo"=>"simple",
               "titulo"=>"Ocurrior un error inesperado", 
               "texto"=>"Las claves no coinciden",
               "icono"=>"error"];
                return json_encode($alerta);
                exit();
            }else{
               $clave=password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
            }
           
         }
          
 
       }else{
         $clave=$check_usuario['usuario_clave'];
       }
        #Verificando usuario#
         if ($check_usuario['usuario_usuario']!= $usuario) {
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
         $usuario_datos_up=[
            [
               "campo_nombre"=>"usuario_nombre",
               "campo_marcador"=>":nombre",
               "campo_valor"=>$nombre
            ],
            [
               "campo_nombre"=>"usuario_apellido",
               "campo_marcador"=>":apellido",
               "campo_valor"=>$apellido
            ],
            [
               "campo_nombre"=>"usuario_usuario",
               "campo_marcador"=>":usuario",
               "campo_valor"=>$usuario
            ],
            [
               "campo_nombre"=>"usuario_clave",
               "campo_marcador"=>":clave",
               "campo_valor"=>$clave
            ],
            [
               "campo_nombre"=>"usuario_email",
               "campo_marcador"=>":email",
               "campo_valor"=>$email
            ],
            [
               "campo_nombre"=>"usuario_actualizado",
               "campo_marcador"=>":actualizado",
               "campo_valor"=>date("Y-m-d H:i:s")
            ],
         ];
         $condicion=["condicion_campo"=>"usuario_id",
                    "condicion_marcador"=>":ID",
                    "condicion_valor"=>$id];
                    
                    
               
                    if ($this->actualizarDatos("usuario",$usuario_datos_up,$condicion)) {
                     if($id==$_SESSION['id']){
                        $_SESSION['nombre']=$nombre;
                        $_SESSION['apellido']=$apellido;
                        $_SESSION['usuario']=$apellido;
                     }
                       $alerta = ["tipo"=>"limpiar",
                             "titulo"=>"Usuario Actualizado", 
                             "texto"=>"El Usuario ".$check_usuario['usuario_nombre']." ".$check_usuario['usuario_apellido']." fue Actualizado",
                             "icono"=>"success"];
         
                    } else {
                      
                       $alerta = ["tipo"=>"simple",
                             "titulo"=>"Ocurrior un error inesperado", 
                             "texto"=>"No se pudo Actualizar el usuario intente mas tarde",
                             "icono"=>"error"];
                             
                    }
                    return json_encode($alerta);

                  
   }
     
   public function actualizarPhoto(){

      return "HOla";
   }

 
 
      }