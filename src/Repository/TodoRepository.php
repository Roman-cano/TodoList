<?php

namespace App\Repository;

use App\Entity\Todo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Todo>
 *
 * @method Todo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Todo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Todo[]    findAll()
 * @method Todo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Todo::class);
    }

    public function add(Todo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findByEtatSorted(string $etat): array
{
    return $this->createQueryBuilder('t')
        ->andWhere('t.etat = :etat')
        ->setParameter('etat', $etat)
        ->orderBy('t.libelle', 'ASC') // Trie par ordre alphabétique de `libelle`
        ->getQuery()
        ->getResult();
}


    public function remove(Todo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function completeState(Todo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity); // Prépare l'entité

        if ($flush) {
            $this->getEntityManager()->flush(); // Exécute la requête SQL pour sauvegarder
        }
    }


    public function findBySearchCriteria($libelle)
    {
        $queryBuilder = $this->createQueryBuilder('t');

        if ($libelle) {
            $queryBuilder->andWhere('t.libelle LIKE :libelle')
                ->setParameter('libelle', '%' . $libelle . '%');
        }



        return $queryBuilder->getQuery()->getResult();
    }



//    /**
//     * @return Todo[] Returns an array of Todo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Todo
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
