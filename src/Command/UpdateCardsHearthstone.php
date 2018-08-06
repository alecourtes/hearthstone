<?php

namespace App\Command;

use App\Service\ApiHearthstone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCardsHearthstone extends Command
{
    private $apiHearthstone;
    private $entityManager;

    public function __construct(ApiHearthstone $apiHearthstone, EntityManagerInterface $entityManager)
    {
        $this->apiHearthstone = $apiHearthstone;
        $this->entityManager = $entityManager
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('hearthstone:update-cards')

            // the short description shown while running "php bin/console list"
            ->setDescription('Synchronize all cards with hearthstone api');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cards = $this->apiHearthstone->getCards();
        $output->writeln([
            'Starting updating hearthstone cards',
            '==========================',
            '',
        ]);
        foreach($cards as $card)
        {
            $output->writeln($card['name']);
        }

        $output->writeln([
        '==========================',
        'Ending Updating hearthstone cards',
        '',
    ]);    }
}