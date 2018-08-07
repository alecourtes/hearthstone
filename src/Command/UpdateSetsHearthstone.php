<?php

namespace App\Command;

use App\Entity\HearthstoneSet;
use App\Service\ApiHearthstone;
use App\Utils\Stringifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateSetsHearthstone extends Command
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

        $setsFR = $this->apiHearthstone->getInfos('sets');
        $setsEN = $this->apiHearthstone->getInfos('sets', 'enEN');

        if(!empty($setsFR))
        {
            $hearthstoneSet = $this->entityManager->getRepository(HearthstoneSet::class);
            foreach($setsFR as $k => $setNameFR)
            {
                if(empty($setNameFR))
                {
                    continue;
                }
                $datas = [];
                $datas['name'] = $setNameFR;
                $datas['code'] = $this->stringifier->slug($setsEN[$k]);

                ($hearthstoneSet->addHearthstoneSet($datas))?$output->writeln("set " . $datas['name'] . " added"):$output->writeln("set " . $datas['name']. " already exist");
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