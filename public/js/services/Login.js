


class Usuario extends Api{

    login($email, $senha){
        this.resquest("/login", "POST", {
            $email, $senha
        })
    }

    registro($nome, $email, $senha){
        this.resquest("/registro", "POST", {
            $email, $senha, $nome
        })
    }
}