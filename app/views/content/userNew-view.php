<section class="section-form">
<div class="conten">
<div class="formulario">
    <form  action="<?php echo APP_URL?>app/ajax/userAjax.php" method="POST" autocomplete="off" class="formularioAjax" id="form" enctype="multipart/form-data" >
		
	<input  type="hidden" name="modulo_usuario"  value="registrar" >
        
	<div class="input-contenedor">
		<i class="fa-solid fa-person"></i>
		<input  type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
			<label class="label">Nombre</label>

		</div>
        <div class="input-contenedor">
			<i class="fa-solid fa-person"></i>
			<input  type="text" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
			<label class="label">Apellido</label>

		</div>
        
        

		<div class="input-contenedor">
		<i class="fa-solid fa-user"></i>
		<input  type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
			<label class="label">Usuario</label>

		</div>
        <div class="input-contenedor">
		<i class="fa-solid fa-envelope"></i>
		<input  type="email" name="usuario_email" maxlength="70"  >
			<label class="label">Email</label>

		</div>

		<div class="input-contenedor">
		<i class="fa-solid fa-lock"></i>
		<input  type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
			<label class="label">Contraseña</label>
		  		
		</div>
        <div class="input-contenedor">
		<i class="fa-solid fa-lock"></i>
		<input  type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
			<label class="label">Repetir contraseña</label>
		  		
		</div>
        <div >
		<input class="block" type="file" name="usuario_foto" accept=".jpg, .png, .jpeg" >
		<label class="label-file" for="file" >Seleciona una Foto</label>
		
						
		</div>
       

		<div>
			<button type="submit" class="guardar">Guardar</button>
		</div>
        <div>
			<button type="reset" class="limpiar">Limpiar</button>
		</div>

	</form>
	</div>
</div>
</section>