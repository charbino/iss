<?php

namespace App\Helper;

use DateTime;
use GuzzleHttp\Client;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class MeteoHelper
 * @package App\Helper
 */
class IssHelper
{

    const URL = 'https://api.wheretheiss.at/v1/';
    const URL_SATELLITE = 'satellites';
    const URL_COORD = 'coordinates';

    const LAT_FR_MIN = 41.340375;
    const LAT_FR_MAX = 51.100000;
    const LONG_FR_MIN = -5.10571;
    const LONG_FR_MAX = 8.242677;

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCurrentPosition()
    {
        $idSattelite   = $this->getSatelliteId();
        $dataSattelite = $this->getDataSatellite($idSattelite);

//        $dataCoordinate = $this->getCoordinates(round($dataSattelite->latitude, 6), round($dataSattelite->longitude, 2));

        //bouchon
        //$dataCoordinate = $this->getCoordinates('48.862725','2.287592000000018');

        $dateNow    = new DateTime();
        $dataResult = array(
            'latitude'   => $dataSattelite->latitude,
            'longitude'  => $dataSattelite->longitude,
            'vitesse'    => $dataSattelite->velocity,
            'units'      => $dataSattelite->units,
            'dateTime'   => date('d-m-Y H:i', $dataSattelite->timestamp),
            'visibility' => $dataSattelite->visibility,
            'altitude'   => $dataSattelite->altitude,
            'now'        => $dateNow->format('d-m-Y H:i'),
        );

        return $dataResult;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getCLient()
    {

        return new Client(['base_uri' => self::URL]);
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSatelliteId()
    {
        $client = $this->getCLient();

        $options = [
            'header' =>
                [
                    'Accept' => 'application/json',
                    'Access-Control-Allow-Origin' => '*'
                ],
        ];

        $reponse = $client->request('GET', self::URL_SATELLITE, $options);
        $responseArray = json_decode((string)$reponse->getBody());

        return $responseArray[0]->id;
    }

    /**
     * @param $idSattelite
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDataSatellite($idSattelite)
    {
        $client = $this->getCLient();
        $url    = self::URL_SATELLITE . "/$idSattelite";

        $options = [
            'header' =>
                [
                    'Accept' => 'application/json'
                ],
        ];

        $reponse = $client->request('GET', $url, $options);

        return json_decode((string)$reponse->getBody());
    }


}
