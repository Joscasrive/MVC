
<section class="section-login">
<div class="contenedor">
<div class="formulario">
    <form  action="" method="POST" autocomplete="off" >
		<h2 >Iniciar Sesion</h2>

		<div class="input-contenedor">
		<i class="fa-solid fa-user"></i>
			<input  type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
			<label class="label">Usuario</label>

		</div>

		<div class="input-contenedor">
		<i class="fa-solid fa-lock"></i>
			<input  type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
			<label class="label">Contraseña</label>
		  		
		</div>

		<div>
			<button type="submit" class="registrar">Iniciar sesion</button>
		</div>

	</form>
	</div>
</div>
</section>

<?php
if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
$insLogin->iniciarSesionControlador();
}

?>