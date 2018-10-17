<?php

namespace App\Controller;

use App\Entity\HearthstoneCard;
use App\Entity\HearthstoneClass;
use App\Entity\HearthstoneSet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{

    public function index(EntityManagerInterface $entityManager)
    {
        $hearthstoneSetRepository = $entityManager->getRepository(HearthstoneSet::class);
        $sets = $hearthstoneSetRepository->findAll();
        $hearthstoneClassRepository = $entityManager->getRepository(HearthstoneClass::class);
        $classes = $hearthstoneClassRepository->findAll();
        $hearthstoneCardRepository = $entityManager->getRepository(HearthstoneCard::class);
        $cards = $hearthstoneCardRepository->findAll();
        return $this->render(
            'index/index.html.twig',
            [
                "sets" => $sets,
                "classes" => $classes,
                "cards" => $cards
            ]
        );

    }

    public function dashboard(EntityManagerInterface $entityManager)
    {
        $hearthstoneSetRepository = $entityManager->getRepository(HearthstoneSet::class);
        $sets = $hearthstoneSetRepository->findAll();
        $hearthstoneClassRepository = $entityManager->getRepository(HearthstoneClass::class);
        $classes = $hearthstoneClassRepository->findAll();
        return $this->render(
            'index/dashboard.html.twig',
            [
                "sets" => $sets,
                "classes" => $classes,
            ]
        );
    }
}