
<header class="header">
    <div class="logo">

 <a href="<?php echo APP_URL?>inicio/"><img src="<?php echo APP_URL?>app/views/img/Mountain.png" alt="Logo del sistema"></a>
 </div>
    
 <nav>
    <ul class="nav-links">
        <li><a >Usuario</a>
        <ul class="submenu">
                <li><a href="<?php echo APP_URL?>userNew/">Nuevo</a></li>
                <li><a href="<?php echo APP_URL?>userList/">Lista</a></li>
                <li><a href="<?php echo APP_URL?>userSearch/">Buscar</a></li>
            </ul>
        </li>  
        <li><a href="#">Categoria</a></li>
        <li><a href="#">Producto</a></li>
        <li><a href="#"><?php echo $_SESSION['usuario']?>
        <ul class="submenu">
                <li><a href="<?php echo APP_URL."userUpdate/".$_SESSION['id']."/"?>">Mi cuenta</a></li>
                <li><a href="<?php echo APP_URL."userPhoto/".$_SESSION['id']."/"?>">Mi foto</a></li>
                
            </ul>
        </a></li>
    </ul>
 </nav>
 
 <a href="<?php echo APP_URL?>logOut/" class="btn" id="btn_exit"><button>Salir</button></a>
        
    
</header>