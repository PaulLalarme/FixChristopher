<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardForm;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/card')]
final class CardController extends AbstractController
{   //page index.html.twig
    #[Route(name: 'app_card_index', methods: ['GET'])]
    public function index(CardRepository $cardRepository): Response
    {   //retourne une vue twig
        return $this->render('card/index.html.twig', [
            //Fournit les personnages dans la vue.
            'cards' => $cardRepository->findAll(),
        ]);
    }
    //Fonction qui instancie un evenement et si le formulaire est valide, alors sauvegarde l'evenement.
    #[Route('/new', name: 'app_card_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {   //Instancie un objet de la classe  Card (personnage)
        $card = new Card();
        //On déclare un objet qui contient un formulaire fournit avec Symfony
        $form = $this->createForm(CardForm::class, $card);
        //Permet de gérer la manière dont est géré le formulaire 
        $form->handleRequest($request);

        //Si le formulaire a été posté et validé
        if ($form->isSubmitted() && $form->isValid()) {
            //Enregistre en BDD
            $entityManager->persist($card);
            $entityManager->flush();

            //redirige sur la route(page) principale
            return $this->redirectToRoute('app_card_index', [], Response::HTTP_SEE_OTHER);
        }

        //retourne la vue avec l'evenement et le formulaire
        return $this->render('card/new.html.twig', [
            'card' => $card,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_card_show', methods: ['GET'])]
    public function show(Card $card): Response //Fonction qui cherche une carte spécifique.
    {
        return $this->render('card/show.html.twig', [
            'card' => $card,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_card_edit', methods: ['GET', 'POST'])] //Fonction qui modifie une carte.
    public function edit(Request $request, Card $card, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CardForm::class, $card); //Créer un formulaire pour la modification
        $form->handleRequest($request);//Puis on envoie la requête afin qu'elle soit gérer

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_card_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('card/edit.html.twig', [
            'card' => $card,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_card_delete', methods: ['POST'])]
    public function delete(Request $request, Card $card, EntityManagerInterface $entityManager): Response
    {
        //Système de protection pour l'action supprimer un évenement
        if ($this->isCsrfTokenValid('delete'.$card->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($card);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_card_index', [], Response::HTTP_SEE_OTHER);
    }
}
