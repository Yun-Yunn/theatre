// Initialisation de la carte
var map = L.map('map').setView([48.8566, 2.3522], 13); // Coordonnées de Paris (modifie-les selon ton lieu)

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Ajout d'un marqueur
var marker = L.marker([48.8566, 2.3522]).addTo(map); // Coordonnées du lieu (modifie-les)

// Ajouter une infobulle au marqueur
marker.bindPopup("<b>Théâtre de Paris</b><br>Adresse: 10 Rue de Paris, 75000 Paris<br><a href='https://www.openstreetmap.org/directions?from=0.0000,0.0000&to=48.8566,2.3522' target='_blank'>Obtenir l'itinéraire</a>").openPopup();
