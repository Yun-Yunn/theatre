document.addEventListener("DOMContentLoaded", function () {
    let currentSlide = 1; // Commence à la première image
    const totalSlides = 3; // Nombre total de slides

    // Fonction pour déplacer le carrousel en fonction de la direction (1 = droite, -1 = gauche)
    function moveSlide(direction) {
        currentSlide += direction;

        // Si on atteint la dernière image, on revient à la première
        if (currentSlide > totalSlides) {
            currentSlide = 1;
        } else if (currentSlide < 1) {
            currentSlide = totalSlides;
        }

        // On change la radio "checked" pour le slide correspondant
        document.getElementById('slide' + currentSlide).checked = true;
    }

    // Défilement automatique toutes les 20 secondes
    setInterval(() => {
        moveSlide(1); // Déplace d'une image vers la droite toutes les 20 secondes
    }, 20000); // 20000ms = 20 secondes

    // Ajout des événements pour les flèches gauche et droite
    document.querySelector('.left').addEventListener('click', function () {
        moveSlide(-1); // Déplace à gauche
    });

    document.querySelector('.right').addEventListener('click', function () {
        moveSlide(1); // Déplace à droite
    });
});
