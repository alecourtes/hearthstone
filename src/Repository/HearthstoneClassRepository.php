<?php

namespace App\Repository;

use App\Entity\HearthstoneClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HearthstoneClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method HearthstoneClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method HearthstoneClass[]    findAll()
 * @method HearthstoneClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HearthstoneClassRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HearthstoneClass::class);
    }

    public function addHearthstoneClass($className)
    {
        if(!empty($className))
        {
            $classExist = $this->findOneBy(['name' => $className]);
            if(!$classExist)
            {
                $class = new HearthstoneClass();
                $class->setName($className);
                $entityManager = $this->getEntityManager();
                $entityManager->persist($class);
                $entityManager->flush();
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
        return true;

    }

//    /**
//     * @return HearthstoneClass[] Returns an array of HearthstoneClass objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HearthstoneClass
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
