const formularioAjax = document.querySelectorAll(".formularioAjax");

formularioAjax.forEach(formulario => {

    formulario.addEventListener("submit",function(e){
        e.preventDefault();
        
        Swal.fire({
            title: "Alerta!",
            text: "Dseas enviar este formulario?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Realizar!",
            cancelButtonText: "No, cancelar!"
          }).then((result) => {
            if (result.isConfirmed) {
                let data = new FormData(this);
                let method=this.getAttribute("method");
                let action = this.getAttribute("action");
                
                let encabezado = new Headers();
                let conf={
                method: method,
                headers:encabezado,
                mode:"cors",
                cahe:"no-cache",
                body:data };
                fetch(action,conf)
                .then(res=>res.json())
                .then(res=>{
                    return alertasAjax(res);
                });
            }
          });

    });
    
});

function alertasAjax(alerta){
    if (alerta.tipo == "simple") {
        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: "Aceptar"
          });
    
    }else if (alerta.tipo == "recargar") {
        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: "Aceptar"
          }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
              
            }
          });
            
        }else if (alerta.tipo=="limpiar") {
            Swal.fire({
                icon: alerta.icono,
                title: alerta.titulo,
                text: alerta.texto,
                confirmButtonText: "Aceptar"
              }).then((result) => {
                if (result.isConfirmed) {
                    
                    document.querySelector(".formularioAjax").reset();
                }
              });
            
        }else if (alerta.tipo == "redireccionar"){
            window.location.href=alerta.url;

        }


}