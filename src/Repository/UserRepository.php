<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, User::class);
	}

	public function resetIndex()
	{
		$connection = $this->getEntityManager()->getConnection();
		$connection->exec("ALTER TABLE user AUTO_INCREMENT = 1;");
	}

	/**
	 * @return User[]
	 */
	public function findAllByClient($idClient): array
	{
		return $this->getQueryDesc($idClient)
			->getQuery()
			->getResult();
	}

	/**
	 * @return User[]
	 */
	public function findUser($idClient, $idUser): array
	{
		return $this->getQueryDesc($idClient, $idUser)
			->getQuery()
			->getResult();
	}

	private function getQueryDesc($idClient, $idUser = null)
	{
		$query = $this->createQueryBuilder('p')
			->orderBy('p.id', 'DESC')
			->where('p.client = :id_client')
			->setParameter('id_client', $idClient);

		if ($idUser)
			$query
				->andWhere('p.id = :id_user')
				->setParameter('id_user', $idUser);

		return $query;
	}

	// /**
	//  * @return User[] Returns an array of User objects
	//  */
	/*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

	/*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
