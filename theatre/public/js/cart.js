// Initialisation du panier vide
let cart = [];
const cartItems = document.getElementById("cart-items");
const totalPriceElement = document.getElementById("total-price");

// Fonction pour ajouter un article au panier
function addToCart(price) {
    cart.push(price);  // Ajoute le prix de la carte au tableau du panier
    updateCartDisplay();  // Mets à jour l'affichage du panier
}

// Fonction pour mettre à jour l'affichage du panier
function updateCartDisplay() {
    cartItems.innerHTML = '';  // Vider le panier avant de le réafficher
    let total = 0;

    // Affichage des articles dans le panier
    cart.forEach(price => {
        total += price;
        const listItem = document.createElement("li");
        listItem.textContent = `Carte cadeau de ${price}€`; // Affichage du prix de chaque carte
        cartItems.appendChild(listItem);
    });

    // Affichage du total
    totalPriceElement.textContent = `${total}€`;
}

// Fonction de validation de la commande (si tu veux un bouton de confirmation)
document.getElementById("checkout-btn").addEventListener("click", function() {
    alert("Commande validée !");
});
