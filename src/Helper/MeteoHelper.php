<?php

namespace App\Helper;

use GuzzleHttp\Client;

/**
 * Class MeteoHelper
 * @package App\Helper
 */
class MeteoHelper
{

    const CLE_API = '71d1bd846bb9ad16930ffc214d3c8f57';
    const URL = 'http://api.openweathermap.org/data/2.5/';
    const WEATER = 'weather';
    const URL_FORECAST = 'daily';
    const URL_DAILY = 'forecast/daily';


    /**
     * @return \GuzzleHttp\Client
     */
    public function getCLient()
    {

        return new Client(['base_uri' => self::URL]);
    }

    /**
     * @param $namecity
     * @param $countryCode
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMeteoByNameCity($namecity, $countryCode)
    {
        $client = $this->getCLient();

        $options = [
            'header' =>
                [
                    'Accept' => 'application/json'
                ],
            'query'  =>
                [
                    'appid' => self::CLE_API,
                    'q'     => $namecity . ',' . $countryCode,
                    'units' => 'metric'
                ]
        ];

        $reponse = $client->request('GET', self::URL, $options);

        if ($reponse->code != 200) {
            return FALSE;
        }
        return json_decode((string)$reponse->getBody());
    }

    /**
     * @param $namecity
     * @param $countryCode
     * @param $numberDay
     *
     * @return bool|\Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMeteoDaily($namecity, $countryCode, $numberDay)
    {
        $client = $this->getCLient();

        $options = [
            'header' =>
                [
                    'Accept' => 'application/json'
                ],
            'query'  =>
                [
                    'appid' => self::CLE_API,
                    'q'     => $namecity . ',' . $countryCode,
                    'units' => 'metric',
                    'cnt'   => $numberDay
                ]
        ];
        $reponse = $client->request('GET', self::URL_DAILY, $options);

        if ($reponse->getStatusCode() != 200) {
            return FALSE;
        }

        return json_decode((string)$reponse->getBody());
    }

}
