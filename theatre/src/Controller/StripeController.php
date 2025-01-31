<?php

// src/Controller/StripeController.php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Evenement;

class StripeController extends AbstractController
{
    // Afficher la page de réservation avec l'événement
    #[Route('/reservation/{id}', name: 'reservation')]
    public function reservation($id, EntityManagerInterface $entityManager): Response
    {
        $evenement = $entityManager->getRepository(Evenement::class)->find($id);
        if (!$evenement) {
            throw $this->createNotFoundException("Événement non trouvé");
        }

        // Transmettre la clé publique Stripe à la vue
        return $this->render('reservation/reservation.html.twig', [
            'evenement' => $evenement,
            'stripe_public_key' => $_ENV['STRIPE_PUBLIC_KEY'],  // Passer la clé publique
        ]);
    }

    // Gérer le paiement avec Stripe
    // Gérer le paiement avec Stripe
    #[Route('/stripe/checkout/{id}', name: 'stripe_checkout')]
public function checkout($id, EntityManagerInterface $entityManager): Response
{
    $evenement = $entityManager->getRepository(Evenement::class)->find($id);
    if (!$evenement) {
        throw $this->createNotFoundException("Événement non trouvé");
    }

    // Assure-toi que Stripe est initialisé avec ta clé secrète
    Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

    // Créer la session de paiement Stripe
    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => ['name' => $evenement->getTitre()],
                'unit_amount' => $evenement->getPrix() * 100, // Convertir en centimes
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'https://127.0.0.1:8000/stripe/success', // Redirige vers succès après paiement
        'cancel_url' => 'https://127.0.0.1:8000/stripe/cancel', // Redirige vers cancel en cas d'annulation
    ]);

    // Renvoie uniquement l'ID de la session en tant que chaîne
    return $this->json($session->id);  // Retourner le sessionId comme chaîne simple
}
    #[Route('/stripe/success', name: 'stripe_success')]
    public function success(): Response
    {
        return $this->render('stripe/success.html.twig');
    }

    // Page d'annulation si l'utilisateur annule le paiement
    #[Route('/stripe/cancel', name: 'stripe_cancel')]
    public function cancel(): Response
    {
        return $this->render('stripe/cancel.html.twig');
    }
}
