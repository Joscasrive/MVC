
<header class="header">
    <div class="logo">

 <img src="<?php echo APP_URL?>app/views/img/Mountain.png" alt="Logo del sistema"  >
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
        <li><a href="#">UserName
        <ul class="submenu">
                <li><a href="<?php echo APP_URL?>userUpdate/">Mi cuenta</a></li>
                <li><a href="<?php echo APP_URL?>userPhoto/">Mi foto</a></li>
                
            </ul>
        </a></li>
    </ul>
 </nav>
 
 <a href="<?php echo APP_URL?>logOut/" class="btn"><button>Salir</button></a>
        
    
</header>