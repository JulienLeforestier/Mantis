<?php

namespace App\Repository;

use App\Entity\Product;
use App\Data\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
        $this->paginator = $paginator;
    }

    public function findAll()
    {
        return $this->findBy(array(), array('title' => 'ASC'));
    }

   /**
     * @return Product[] Returns an array of Product objects
     */
    public function findBySearch($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.title LIKE :val')
            ->orWhere('p.description LIKE :val')
            ->setParameter('val', "%$value%")
            ->orderBy('p.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('p', 'c', 't', 'm', 'pr')
            ->join('p.category', 'c')
            ->join('p.type', 't')
            ->join('p.mark', 'm')
            ->join('p.producer', 'pr');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('p.title LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->min)) {
            $query = $query
                ->andWhere('p.price >= :min')
                ->setParameter('min', $search->min);
        }

        if (!empty($search->max)) {
            $query = $query
                ->andWhere('p.price <= :max')
                ->setParameter('max', $search->max);
        }

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        if (!empty($search->types)) {
            $query = $query
                ->andWhere('t.id IN (:types)')
                ->setParameter('types', $search->types);
        }

        if (!empty($search->marks)) {
            $query = $query
                ->andWhere('m.id IN (:marks)')
                ->setParameter('marks', $search->marks);
        }

        if (!empty($search->producers)) {
            $query = $query
                ->andWhere('pr.id IN (:producers)')
                ->setParameter('producers', $search->producers);
        }

        return $this->paginator->paginate(
            $query,
            $search->page,
            9
        );
    }

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
