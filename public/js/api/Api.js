

class Api{

    constructor(){
        this.url = "http://localhost:8080/api"
    }

    async resquest(endpoint, method, body = null){
        const response = await fetch(this.url + endpoint, {
            method,
              headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("token")
            },

            body: body ? JSON.stringify(body) : null
        })

        return await response.json();
    }
}