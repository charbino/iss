<?php

namespace App\Controller;

use App\Helper\IssHelper;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("iss")
 *
 * Class Iss
 *
 * @package Marcelo\ApiBundle\Controller
 *
 * @author  Sébatien Framinet <sebastien.framinet@asdoria.com>
 *
 */
class Iss extends AbstractController
{
    /**
     *
     * @Route("/",methods={"GET"}, name="iss_index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('iss/index.html.twig', [

        ]);
    }

    /**
     *
     * @Route("/position",methods={"GET"}, name="iss_position", options = { "expose" = true })
     *
     * @param Request   $request
     * @param IssHelper $helper
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function position(Request $request, IssHelper $helper)
    {

        $result = $helper->getCurrentPosition();

        return new JsonResponse($result);
    }


}


