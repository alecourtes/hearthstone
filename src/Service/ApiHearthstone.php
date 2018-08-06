<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Unirest;


class ApiHearthstone
{
    private $params;
    const ignoredExtensions = ['Tavern Brawl', 'Taverns of Time', 'Hero Skins', 'Missions', 'Credits', 'System', 'Debug', 'Promo', 'Hall of Fame'];

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function getCards()
    {
        $cards = [];
        $apiUrl = $this->params->get('hearthstone.api.url.allcards');
        $apiToken = $this->params->get('hearthstone.api.token');

        $headers = [
            'Accept' => 'application/json',
            "Content-Type" => "application/x-www-form-urlencoded",
            'X-Mashape-Key' => $apiToken
        ];
        $query = [
            'locale' => 'frFR'
        ];
        try{
            Unirest\Request::jsonOpts(JSON_OBJECT_AS_ARRAY);
            $response = Unirest\Request::get($apiUrl, $headers, $query);
            $extensions = $response->body;
            echo "<pre>";
            \Doctrine\Common\Util\Debug::dump($extensions);
            die;
            foreach($extensions as $extensionName => $cards)
            {
                if(!in_array($extensionName, self::ignoredExtensions))
                {
                    echo $extensionName . "<br/>";
                }

            }
            die;
            $cards = $body['The Boomsday Project'];
        }
        catch(\Exception $e)
        {
            die($e->getMessage());
        }

        return $cards;
    }

    public function getInfos(String $type): array
    {
        $infos = [];
        $apiUrl = $this->params->get('hearthstone.api.url.infos');
        $apiToken = $this->params->get('hearthstone.api.token');

        $headers = [
            'Accept' => 'application/json',
            "Content-Type" => "application/x-www-form-urlencoded",
            'X-Mashape-Key' => $apiToken
        ];
        $query = [
            'locale' => 'frFR'
        ];
        try{
            Unirest\Request::jsonOpts(JSON_OBJECT_AS_ARRAY);
            $response = Unirest\Request::get($apiUrl, $headers, $query);
            $body = $response->body;
            if(!empty($body[$type]))
            {
                return $body[$type];
            }
        }
        catch(\Exception $e)
        {
            die($e->getMessage());
        }

        return $infos;
    }

}