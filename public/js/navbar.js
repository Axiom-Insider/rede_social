const nav = document.getElementById("navbar");
const token_navbar = localStorage.getItem("token");
const pagina_navbar = window.location.pathname.split("/").pop();

    //sistema para carregar navbar depedendo se o usuario esta logado ou não
    if(token_navbar){
        fetch("models/navbarOn.html")
        .then(res => res.text())
        .then(data=>{
            nav.innerHTML = data;

            const a = document.getElementById(pagina_navbar);
            console.log(a, pagina_navbar);
            
            if(a){
                a.style.color = "white";
                a.style.backgroundColor = "#163ba1"
            }
        })
    }else{
         fetch("models/navbarOff.html")
        .then(res => res.text())
        .then(data=>{
            nav.innerHTML = data;

            const a = document.getElementById(pagina_navbar);
            
            if(a){
                a.style.color = "white";
                a.style.backgroundColor = "#163ba1"
            }
        })
    }