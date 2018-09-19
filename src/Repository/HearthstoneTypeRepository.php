<?php

namespace App\Repository;

use App\Entity\HearthstoneType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HearthstoneType|null find($id, $lockMode = null, $lockVersion = null)
 * @method HearthstoneType|null findOneBy(array $criteria, array $orderBy = null)
 * @method HearthstoneType[]    findAll()
 * @method HearthstoneType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HearthstoneTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HearthstoneType::class);
    }

    public function addHearthstoneType($datas)
    {
        if(!empty($datas))
        {
            $setExist = $this->findOneBy(['name' => $datas['name']]);
            if(!$setExist)
            {
                $set = new HearthstoneType();
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
}
