//gets();



function gets()
{
    let user = prompt("User: ");
    let password = prompt("Password: ");
    
    if(user != "admin" || password != "admin")
    {
       let loc = "http://"+ window.location.hostname + "/freeposts/?page=home";
       alert("Usuário ou senha inválidos.");
       window.location.href = loc;
    }
}
