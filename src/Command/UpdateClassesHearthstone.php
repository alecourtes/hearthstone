<?php

namespace App\Command;

use App\Entity\HearthstoneClass;
use App\Service\ApiHearthstone;
use App\Utils\Stringifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateClassesHearthstone extends Command
{
    private $apiHearthstone;
    private $entityManager;
    private $stringifier;

    public function __construct(ApiHearthstone $apiHearthstone, EntityManagerInterface $entityManager, Stringifier $stringifier)
    {
        $this->apiHearthstone = $apiHearthstone;
        $this->entityManager = $entityManager;
        $this->stringifier = $stringifier;
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

        $classesFR = $this->apiHearthstone->getInfos('classes');
        $classesEN = $this->apiHearthstone->getInfos('classes', 'enEN');
        if(!empty($classesFR))
        {
            $hearthstoneClass = $this->entityManager->getRepository(HearthstoneClass::class);
            foreach($classesFR as $k => $classNameFR)
            {
                if(empty($classNameFR))
                {
                    continue;
                }
                $datas = [];
                $datas['name'] = $classNameFR;
                $datas['code'] = $this->stringifier->slug($classesEN[$k]);
                ($hearthstoneClass->addHearthstoneClass($datas))?$output->writeln("Class " . $classNameFR . " added"):$output->writeln("Class " . $classNameFR. " already exist");
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