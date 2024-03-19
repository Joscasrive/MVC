

<div class="tabla">
    <H2>Lista de Usuarios</H2>
<?php 
use app\controllers\userController;
$insUsuario=new userController();
echo $insUsuario->listarUsuarioControlador($url[1],15,$url[0],"");


?>

</div>