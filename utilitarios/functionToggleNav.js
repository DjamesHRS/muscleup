function toggleNav() {
    var sidenav = document.getElementById("mySidenav");
    var topbar = document.querySelector(".topbar");
    var logoTopbar = document.querySelector(".logo-topbar");
    var main = document.getElementById("main");

    // Alterna a classe 'collapsed' para a barra lateral
    sidenav.classList.toggle('collapsed');

    // Verifica o estado e ajusta os estilos
    if (sidenav.classList.contains("collapsed")) {
        console.log("Collapsed"); // Verificar no console
        sidenav.style.width = "100px";
        main.style.marginLeft = "100px";
        topbar.style.left = "100px";
        logoTopbar.style.marginLeft = "100px";
    } else {
        console.log("Expanded"); // Verificar no console
        sidenav.style.width = "250px";
        main.style.marginLeft = "250px";
        topbar.style.left = "250px";
        logoTopbar.style.marginLeft = "250px";
    }
}
