<?php

namespace App\Command;

use App\Entity\HearthstoneClass;
use App\Service\ApiHearthstone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateClassesHearthstone extends Command
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
            ->setName('hearthstone:update-classes')
            ->setDescription('Synchronize all classes with hearthstone api');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Starting updating hearthstone classes',
            '==========================',
            '',
        ]);

        $classes = $this->apiHearthstone->getInfos('classes');
        if(!empty($classes))
        {
            $hearthstoneClass = $this->entityManager->getRepository(HearthstoneClass::class);
            foreach($classes as $classname)
            {
                ($hearthstoneClass->addHearthstoneClass($classname))?$output->writeln("Class " . $classname . " added"):$output->writeln("Class " . $classname. " already exist");
            }
        }
        else{
            $output->writeln("No class to update");
        }

        $output->writeln([
        '==========================',
        'Ending Updating hearthstone classes',
        '',
    ]);    }
}