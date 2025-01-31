<?php

namespace App\Controller;

use App\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // Import correct de la classe Request
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EvenementRepository;
use Knp\Component\Pager\PaginatorInterface;

final class HomeController extends AbstractController
{

    #[Route('/home', name: 'app_home')]
    public function index(EvenementRepository $evenementRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // Récupérer les événements valides depuis le repository
        $valideevenements = $evenementRepository->findvalideEvent(true);

        // Appliquer la pagination
        $pagination = $paginator->paginate(
            $valideevenements,  // Les événements à paginer
            $request->query->getInt('page', 1),  // Page actuelle (défaut à 1)
            2
            // Nombre d'événements par page
        );

        // Retourner la vue avec les événements paginés et la pagination
        return $this->render('home/index.html.twig', [
            "eventsvalides" => $pagination, // Passe la pagination à la vue
        ]);
    }

    #[Route('/profile', name: 'profile')]
    public function profile($user)
    {
        return $this->render('home/profile.html.twig', [
            "utilisateur" => $user
        ]);
    }
    #[Route('/reservation/{id}', name: 'reservation')]
    public function reservation(EvenementRepository $evenementRepository, int $id): Response
    {
        $evenement = $evenementRepository->find($id);

        if (!$evenement) {
            throw $this->createNotFoundException('L\'événement n\'existe pas.');
        }

        return $this->render('reservation/reservation.html.twig', [
            "evenement" => $evenement
        ]);
    }
    #[Route('/reserve_event/{id}', name: 'reserve_event', methods: ['POST'])]
    public function reserveEvent(EvenementRepository $evenementRepository, Request $request, int $id): Response
    {
        $evenement = $evenementRepository->find($id);

        if (!$evenement) {
            throw $this->createNotFoundException("L'événement n'existe pas.");
        }

        // Récupérer le nombre de places réservées
        $nombrePlaces = $request->request->get('nombrePlaces', 1);

        // Simuler la réservation (ici, il faudra ajouter la logique pour stocker la réservation en BDD)
        $message = "Réservation confirmée pour {$nombrePlaces} place(s) à l'événement : {$evenement->getTitre()}.";

        return new Response($message);
    }

    #[Route('/paypal', name: 'paypal')]
    public function paypal()
    {
        return $this->render('home/paypal.html.twig', []);
    }
}
