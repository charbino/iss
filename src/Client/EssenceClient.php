<?php


namespace App\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class EssenceClient
 *
 * @package App\Client
 *
 * @author  Sébatien Framinet <sebastien.framinet@asdoria.com>
 *
 */
class EssenceClient extends Client
{
    const URL_DATAGOUVE_ESSENCE = "https://donnees.roulez-eco.fr/opendata/";
    const URL_INSTANTANE = "instantane";
    const URL_JOUR = "jour";
    const URL_ANNEE = "annee";

    /**
     * EssenceClient constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config['base_uri'] = self::URL_DATAGOUVE_ESSENCE;

        parent::__construct($config);
    }

    /**
     * @param $resource
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getInstantane($resource) : ResponseInterface
    {
        return $this->request('GET',self::URL_INSTANTANE,['sink' => $resource]);
    }


}
