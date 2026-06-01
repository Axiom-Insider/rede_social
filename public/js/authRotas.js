const token = localStorage.getItem("token");
const pagina = window.location.pathname.split("/").pop();

    if(token && (pagina === "login.html" || pagina === "registro.html")){
        window.location.href = "inicio.html";
    }

      if(!token && (pagina === "inicio.html" || pagina === "perfil.html")){
        window.location.href = "login.html";
    }