const nav = document.getElementById("navbar");
const token = localStorage.getItem("token");
const pagina = window.location.pathname.split("/").pop();

    //sistema para carregar navbar depedendo se o usuario esta logado ou não
    if(token){
        fetch("models/navbarOn.html")
        .then(res => res.text())
        .then(data=>{
            nav.innerHTML = data;

            const a = document.getElementById(pagina);
            console.log(a, pagina);
            
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

            const a = document.getElementById(pagina);
            
            if(a){
                a.style.color = "white";
                a.style.backgroundColor = "#163ba1"
            }
        })
    }