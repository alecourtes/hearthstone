<?php

namespace App\Repository;

use App\Entity\HearthstoneCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HearthstoneCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method HearthstoneCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method HearthstoneCard[]    findAll()
 * @method HearthstoneCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HearthstoneCardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HearthstoneCard::class);
    }

    public function createHearthstoneCard($cardDatas)
    {
        if(!empty($cardDatas))
        {
            $cardExist = $this->findOneBy(['cardId' => $cardDatas['cardId']]);
            if(!$cardExist)
            {
               
                $card = new HearthstoneCard();
                $card->setName($cardDatas['name']);
                $card->setCardId($cardDatas['cardId']);
                $card->setDescription($cardDatas['description']);
                $card->setHearthstoneClass($cardDatas['class']);
                $card->setHearthstoneSet($cardDatas['set']);
                $card->setHearthstoneType($cardDatas['type']);
                $card->setAttack($cardDatas['attack']);
                $card->setHealth($cardDatas['health']);
                $card->setMedia($cardDatas['media']);
                $card->setMediaGold($cardDatas['mediaGold']);
                $entityManager = $this->getEntityManager();
                $entityManager->persist($card);
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

    public function updateHearthstoneCard($cardDatas)
    {
        if(!empty($cardDatas))
        {
            $card = $this->findOneBy(['cardId' => $cardDatas['cardId']]);
            if($card)
            {


                $card->setName($cardDatas['name']);
                $card->setCardId($cardDatas['cardId']);
                $card->setDescription($cardDatas['text']);
                $card->setHearthstoneClass($cardDatas['class']);
                $card->setHearthstoneSet($cardDatas['set']);
                $card->setHearthstoneType($cardDatas['type']);
                $card->setAttack($cardDatas['attack']);
                $card->setHealth($cardDatas['health']);
                $card->setMedia($cardDatas['media']);
                $card->setMediaGold($cardDatas['mediaGold']);
                $entityManager = $this->getEntityManager();
                $entityManager->persist($card);
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
