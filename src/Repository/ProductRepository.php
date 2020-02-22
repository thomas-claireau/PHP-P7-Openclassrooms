<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Product::class);
	}

	public function resetIndex()
	{
		$connection = $this->getEntityManager()->getConnection();
		$connection->exec("ALTER TABLE product AUTO_INCREMENT = 1;");
	}

	/**
	 * @return Product[]
	 */
	public function findAll(): array
	{
		return $this->getQueryDesc()
			->getQuery()
			->getResult();
	}

	private function getQueryDesc()
	{
		return $this->createQueryBuilder('p')
			->orderBy('p.id', 'DESC');
	}

	// /**
	//  * @return Product[] Returns an array of Product objects
	//  */
	/*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

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
