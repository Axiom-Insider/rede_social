const usuario = new Usuario();

const form = document.getElementById("form-login");

form.addEventListener("submit", async (e) => {

    e.preventDefault();

    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;

    
    try {
        const resposta = await usuario.login(email, senha);
        
        console.log(resposta);
        if (resposta.success) {
    
            localStorage.setItem("token", resposta.token);
    
            window.location.href = "home.html";
    
        } else {
            console.log("errro");
            alert(resposta.message);
    
        }
    } catch (error) {
        alert(error);
    }


});