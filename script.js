// function toggleMenu() {
//     const menu = document.querySelector(".link");
//     menu.classList.toggle("active");
// }



document.addEventListener("DOMContentLoaded", function () {
    const menu = document.getElementById("menuNavigation");
    const ouvrir = document.getElementById("menuToggle");
    const fermer = document.getElementById("closeMenu");

    if (!menu || !ouvrir || !fermer) return;

    function ouvrirMenu() {
        menu.classList.add("active");
        document.body.classList.add("menu-open");
        ouvrir.setAttribute("aria-expanded", "true");
    }

    function fermerMenu() {
        menu.classList.remove("active");
        document.body.classList.remove("menu-open");
        ouvrir.setAttribute("aria-expanded", "false");
    }

    ouvrir.addEventListener("click", ouvrirMenu);
    fermer.addEventListener("click", fermerMenu);

    // Fermer après avoir sélectionné une page
    menu.querySelectorAll(".nav-links a").forEach(function (lien) {
        lien.addEventListener("click", fermerMenu);
    });

    // Fermer avec la touche Échap
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            fermerMenu();
        }
    });
});
