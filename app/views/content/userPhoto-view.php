<div >
<?php 
$id = $insLogin->limpiarCadena($url[1]);
 if($id==$_SESSION['id']){          
    ?>
	<h1 >Mi foto de perfil</h1>
	<h2 >Actualizar foto de perfil</h2>
    <?php  }else{        ?>
	<h1 >Usuarios</h1>
	<h2>Actualizar foto de perfil</h2>
    <?php  }       ?>
</div>
<div class="container pb-6 pt-6">
	

<?php  require_once("./app/views/inc/btn_back.php") ;    
$datos=$insLogin->seleccionarDatos("Unico","usuario","usuario_id",$id);
if ($datos->rowCount()==1) {
	$datos=$datos->fetch();

?>


	<h2 class="title has-text-centered"><?php echo $datos['usuario_nombre']." ".$datos['usuario_apellido']; ?></h2>

	<p class="has-text-centered pb-6"><strong>Usuario creado:</strong>  <?php  echo date("d-m-Y h:i:s A",strtotime($datos['usuario_creado'])); ?> &nbsp; <strong>Usuario actualizado:</strong>  <strong>Usuario actualizado:</strong> <?php  echo date("d-m-Y h:i:s A",strtotime($datos['usuario_actualizado'])); ?></p>

	<div class="columns">
		<div class="column is-two-fifths">
		<?php if(is_file("./app/views/fotos/".$datos['usuario_foto'])){?>
			<figure class="image mb-6">
                <img class="is-rounded" src="<?php echo APP_URL."app/views/fotos/".$datos['usuario_foto']; ?>">
			</figure>
			
			<form class="formularioAjax" action="<?php echo APP_URL?>app/ajax/userAjax.php" method="POST" autocomplete="off" >

				<input type="hidden" name="modulo_usuario" value="eliminarFoto">
				<input type="hidden" name="usuario_id" value="<?php echo $datos['usuario_id']; ?>">

				<p class="has-text-centered">
					<button type="submit" class="button is-danger is-rounded">Eliminar foto</button>
				</p>
			</form>
		<?php }else{         ?>
			<figure class="image mb-6">
			  	<img class="is-rounded" src="<?php echo APP_URL."app/views/fotos/default.png" ?>">
			</figure>
	<?php }         ?>
		</div>


		<div class="column">
			<form class="mb-6 has-text-centered formularioAjax" action="<?php echo APP_URL?>app/ajax/userAjax.php" method="POST" enctype="multipart/form-data" autocomplete="off" >

				<input type="hidden" name="modulo_usuario" value="<?php echo $datos['usuario_id']; ?>">
				<input type="hidden" name="usuario_id" value="1">
				
				<label>Foto o imagen del usuario</label><br>

				<div class="file has-name is-boxed is-justify-content-center mb-6">
				  	<label class="file-label">
						<input class="file-input" type="file" name="usuario_foto" accept=".jpg, .png, .jpeg" >
						<span class="file-cta">
							<span class="file-label">
								Seleccione una foto
							</span>
						</span>
						<span class="file-name">JPG, JPEG, PNG. (MAX 5MB)</span>
					</label>
				</div>
				<p class="has-text-centered">
					<button type="submit" class="button is-success is-rounded">Actualizar foto</button>
				</p>
			</form>
		</div>
	</div>
	

    <?php 
	}else {
		require_once("./app/views/inc/error_alerta.php");
	}
?>

</div>