<?php

namespace App\Repository;

use App\Entity\HearthstoneSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HearthstoneSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method HearthstoneSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method HearthstoneSet[]    findAll()
 * @method HearthstoneSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HearthstoneSetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HearthstoneSet::class);
    }

    public function addHearthstoneSet($datas)
    {
        if(!empty($datas))
        {
            $setExist = $this->findOneBy(['name' => $datas['name']]);
            if(!$setExist)
            {
                $set = new HearthstoneSet();
                $set->setName($datas['name']);
                $set->setCode($datas['code']);
                $entityManager = $this->getEntityManager();
                $entityManager->persist($set);
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
//     * @return HearthstoneExtension[] Returns an array of HearthstoneExtension objects
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
    public function findOneBySomeField($value): ?HearthstoneExtension
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
