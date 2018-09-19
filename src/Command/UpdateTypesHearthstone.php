<?php

namespace App\Command;

use App\Entity\HearthstoneType;
use App\Service\ApiHearthstone;
use App\Utils\Stringifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateTypesHearthstone extends Command
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
            ->setName('hearthstone:update-types')
            ->setDescription('Synchronize all types with hearthstone api');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Starting updating hearthstone types',
            '==========================',
            '',
        ]);

        $setsFR = $this->apiHearthstone->getInfos('types');
        $setsEN = $this->apiHearthstone->getInfos('types', 'enEN');

        if(!empty($setsFR))
        {
            $hearthstoneType = $this->entityManager->getRepository(HearthstoneType::class);
            foreach($setsFR as $k => $setNameFR)
            {
                if(empty($setNameFR))
                {
                    continue;
                }
                $datas = [];
                $datas['name'] = $setNameFR;
                $datas['code'] = $this->stringifier->slug($setsEN[$k]);

                ($hearthstoneType->addHearthstoneType($datas))?$output->writeln("type " . $datas['name'] . " added"):$output->writeln("set " . $datas['name']. " already exist");
            }
        }
        else{
            $output->writeln("No type to update");
        }

        $output->writeln([
        '==========================',
        'Ending Updating hearthstone types',
        '',
    ]);    }
}