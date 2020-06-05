<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Essence
 *
 *  @Route("/essence")
 *
 * @package App\Controller
 * @author  Sébatien Framinet <sebastien.framinet@asdoria.com>
 *
 */
class Index extends AbstractController
{

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        return $this->render('index.html.twig');
    }
}
