var deleteAccButton = document.getElementById("deleteAccButton");
deleteAccButton.addEventListener("click", function(){
    if(confirm("Vill du radera ditt konto?"))
    {
        window.location.href = "deleteAcc.php";
    }
});