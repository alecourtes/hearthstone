<?php

namespace App\Controller;

use App\Entity\HearthstoneSet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{

    public function index(EntityManagerInterface $entityManager)
    {
        $hearthstoneSetRepository = $entityManager->getRepository(HearthstoneSet::class);
        $sets = $hearthstoneSetRepository->findAll();
        return $this->render(
            'index/index.html.twig',
            ["sets" => $sets]
        );

    }
}