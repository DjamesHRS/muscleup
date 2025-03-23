// loadNavbar.js
document.addEventListener("DOMContentLoaded", function () {
    const navbarElement = document.getElementById("navbar");
    
        // Faz uma requisição para carregar o HTML
        fetch("../../utilitarios/navbarAdm.html")
        .then(response => response.text())
        .then(data => {
        navbarElement.innerHTML = data; // Insere o conteúdo no elemento
    })
    .catch(error => console.error('Erro ao carregar a navbar:', error));
});