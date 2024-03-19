
<div class="contenedor-inicio">

  	
    <?php
        if(is_file("./app/views/fotos/".$_SESSION['foto'])){
    			echo '<img class="img_usuario" src="'.APP_URL.'app/views/fotos/'.$_SESSION['foto'].'">';
    	}else{
    			echo '<img class="img_usuario" src="'.APP_URL.'app/views/fotos/default.png">';
    	}
    ?>
		
  	
  	<div  class="usuario_nombre">
  		<h2 >¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
  	</div>
</div>