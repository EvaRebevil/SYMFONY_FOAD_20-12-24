<?php

namespace App\Controller;

use App\Form\SearchBookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{
    /**
     * Permet la recherche des livres par titre ou auteur.
     *
     * @param Request $request L'objet Request contenant les données du formulaire.
     * @param BookRepository $bookRepository Le repository des livres pour exécuter la recherche.
     * @return Response
     */
    public function search(Request $request, BookRepository $bookRepository): Response
    {
        // Crée le formulaire de recherche
        $form = $this->createForm(SearchBookType::class);
        $form->handleRequest($request);

        $books = []; // Tableau pour les résultats de recherche

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère la valeur du champ "query" dans le formulaire
            $query = $form->get('query')->getData();

            // Exécute la recherche dans le repository
            $books = $bookRepository->searchBooks($query);
        }

        // Retourne la vue avec le formulaire et les résultats
        return $this->render('book/search.html.twig', [
            'form' => $form->createView(),
            'books' => $books,
        ]);
    }
}
