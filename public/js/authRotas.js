const token = localStorage.getItem("token");
const pagina = window.location.pathname.split("/").pop();

    if(token && (pagina === "login" || pagina === "registro")){
        window.location.href = "inicio";
    }

      if(!token && (pagina === "inicio" || pagina === "perfil")){
        window.location.href = "login";
    }