<?php

namespace App\Controller;

use App\Form\FilterBookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{
    /**
     * Affiche les livres filtrés par catégorie.
     *
     * @param Request $request L'objet Request contenant les données du formulaire.
     * @param BookRepository $bookRepository Le repository pour récupérer les livres.
     * @return Response La réponse HTML à afficher.
     */
    public function filter(Request $request, BookRepository $bookRepository): Response
    {
        // Crée le formulaire de filtrage
        $form = $this->createForm(FilterBookType::class);
        $form->handleRequest($request);

        $books = []; // Tableau pour les résultats

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère la catégorie sélectionnée
            $category = $form->get('category')->getData();

            if ($category) {
                // Recherche les livres pour cette catégorie
                $books = $bookRepository->findBy(['category' => $category]);
            } else {
                // Si aucune catégorie n'est sélectionnée, affiche tous les livres
                $books = $bookRepository->findAll();
            }
        }

        // Retourne la vue avec le formulaire et les résultats
        return $this->render('book/filter.html.twig', [
            'form' => $form->createView(),
            'books' => $books,
        ]);
    }
}

