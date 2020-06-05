<?php

namespace App\Controller;

use App\Helper\MeteoHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("meteo")
 *
 *
 * Class Meteo
 * @package App\Controller
 */
class Meteo extends AbstractController
{

    const DEFAULT_CITY = 'albertville';
    const COUNTRY_CODE = 'fr';

    /**
     *
     * @Route("/",methods={"GET"}, name="meteo_index")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Helper\MeteoHelper                   $helper
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(Request $request, MeteoHelper $helper)
    {

        $meteoFiveDay = $helper->getMeteoDaily(self::DEFAULT_CITY, self::COUNTRY_CODE, 5);

        return $this->render('meteo/index.html.twig', [
            'meteoFiveDay' => $meteoFiveDay,
        ]);
    }


}
