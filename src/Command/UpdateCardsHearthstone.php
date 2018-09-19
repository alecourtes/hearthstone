<?php

namespace App\Command;

use App\Entity\HearthstoneCard;
use App\Entity\HearthstoneClass;
use App\Entity\HearthstoneSet;
use App\Entity\HearthstoneType;
use App\Service\ApiHearthstone;
use App\Utils\Stringifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCardsHearthstone extends Command
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
            ->setName('hearthstone:update-card')
            ->setDescription('Synchronize all cards with hearthstone api');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Starting updating hearthstone cards',
            '==========================',
            '',
        ]);

        $cards = $this->apiHearthstone->getCards();
        if(!empty($cards))
        {
            $hearthstoneCard = $this->entityManager->getRepository(HearthstoneCard::class);
            $hearthstoneSet = $this->entityManager->getRepository(HearthstoneSet::class);
            $hearthstoneClass = $this->entityManager->getRepository(HearthstoneClass::class);
            $hearthstoneType = $this->entityManager->getRepository(HearthstoneType::class);

            $i = 0;
            foreach($cards as $extension => $cardsExtension)
            {
                $output->writeln('<fg=green>Chargement cartes de l\'extension '.$extension.'</>');

                foreach($cardsExtension as $card)
                {
                    $i++;
                    $datas = [];
                    $datas['extension'] = $extension;
                    $datas['name'] = (isset($card['name']))?$card['name']:'';
                    $datas['text'] = (isset($card['text']))?$card['text']:'';
                    $datas['playerClass'] = (isset($card['playerClass']))?$card['playerClass']:'';
                    $datas['type'] = (isset($card['type']))?$card['type']:'';
                    $datas['attack'] = (isset($card['attack']))?$card['attack']:null;
                    $datas['health'] = (isset($card['health']))?$card['health']:null;
                    $datas['media'] = (isset($card['img']))?$card['img']:null;
                    $datas['mediaGold'] = (isset($card['imgGold']))?$card['imgGold']:null;

                    //cardId is needed for unicity of card un database
                    if(!isset($card['cardId']))
                    {
                        continue;
                    }
                    $datas['cardId'] = $card['cardId'];
                    $datas['description'] = (isset($card['text']))?$card['text']:'';
                    $output->writeln('<info>Card N° '. $i .'</info>');
                    $output->writeln('<info>Id Card : '. $datas['cardId'] .'</info>');
                    $output->writeln('<info>Card name : '. $datas['name'] .'</info>');
                    $output->writeln('<info>Card playerClass : '. $datas['playerClass'] .'</info>');
                    $output->writeln('<info>Card Type : '. $datas['type'] .'</info>');
                    $output->writeln('<info>Card extension : '. $extension .'</info>');
                    $output->writeln('<info>Card attack : '. $datas['attack'] .'</info>');
                    $output->writeln('<info>Card $health : '. $datas['health'] .'</info>');
                    $output->writeln('<info>Card media : '. $datas['media'] .'</info>');
                    $output->writeln('<info>Card mediaGold : '. $datas['mediaGold'] .'</info>');
                    $output->writeln('<comment>Card Description : '. $datas['text'] .'</comment>');
                    $output->writeln('-----------------------------------------------');
                    $set = $hearthstoneSet->findOneBy(['code' => $this->stringifier->slug($extension)]);
                    $datas['set'] = $set;
                    $class = $hearthstoneClass->findOneBy(['code' => $this->stringifier->slug($datas['playerClass'])]);
                    $datas['class'] = $class;
                    $type = $hearthstoneType->findOneBy(['code' => $this->stringifier->slug($datas['type'])]);
                    $datas['type'] = $type;
                    if (!$set || !$class)
                    {
                        $output->writeln('<error> Extension or class not exist</error>');
                        continue;
                    }
                    else{
                        $card = $hearthstoneCard->findOneBy(['cardId' => $datas['cardId']]);
                        if($card)
                        {
                            $hearthstoneCard->updateHearthstoneCard($datas);
                        }
                        else{
                            $hearthstoneCard->createHearthstoneCard($datas);

                        }
                    }

                }
            }
        }
        else{
            $output->writeln("No card to update");
        }

        $output->writeln([
            '==========================',
            'Ending Updating hearthstone cards',
            '',
        ]);    }
}