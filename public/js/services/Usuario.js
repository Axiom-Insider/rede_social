


class Usuario extends Api{

    async login($email, $senha){
        return await this.resquest("/login", "POST", {
            $email, $senha
        })
    }

    registro($nome, $email, $senha){
        this.resquest("/registro", "POST", {
            $email, $senha, $nome
        })
    }
}