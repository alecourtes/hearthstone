<?php

namespace App\Command;

use App\Entity\HearthstoneSet;
use App\Service\ApiHearthstone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateSetsHearthstone extends Command
{
    private $apiHearthstone;
    private $entityManager;

    public function __construct(ApiHearthstone $apiHearthstone, EntityManagerInterface $entityManager)
    {
        $this->apiHearthstone = $apiHearthstone;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('hearthstone:update-sets')
            ->setDescription('Synchronize all sets with hearthstone api');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Starting updating hearthstone sets',
            '==========================',
            '',
        ]);

        $sets = $this->apiHearthstone->getInfos('sets');
        if(!empty($sets))
        {
            $hearthstoneSet = $this->entityManager->getRepository(HearthstoneSet::class);
            foreach($sets as $setName)
            {
                ($hearthstoneSet->addHearthstoneSet($setName))?$output->writeln("set " . $setName . " added"):$output->writeln("set " . $setName. " already exist");
            }
        }
        else{
            $output->writeln("No set to update");
        }

        $output->writeln([
        '==========================',
        'Ending Updating hearthstone sets',
        '',
    ]);    }
}