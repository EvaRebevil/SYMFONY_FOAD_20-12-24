<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * Recherche des livres par titre ou auteur.
     *
     * @param string|null
     * @return Book[] Retourne un tableau d'entités Book correspondant à la recherche.
     */
    public function searchBooks(?string $query): array
    {
        // Si aucun terme n'est fourni, retourne tous les livres
        if (!$query) {
            return $this->findAll();
        }

        // Crée une requête avec un QueryBuilder pour rechercher dans les champs "title" et "author"
        return $this->createQueryBuilder('b')
            ->where('b.title LIKE :query OR b.author LIKE :query')
            ->setParameter('query', '%' . $query . '%') // Ajoute des % pour rechercher n'importe où dans le texte
            ->getQuery()
            ->getResult();
    }
}
