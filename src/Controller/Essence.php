<?php


namespace App\Controller;

use App\Repository\HistoryImportEssenceDataRepository;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Class Essence
 *
 * @Route("/essence")
 *
 * @package App\Controller
 * @author  Sébatien Framinet <sebastien.framinet@asdoria.com>
 *
 */
class Essence extends AbstractController
{

    /**
     * @Route("/",methods={"GET"}, name="essence_index")
     *
     * @param Request                            $request
     * @param HistoryImportEssenceDataRepository $repository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function index(Request $request, HistoryImportEssenceDataRepository $repository)
    {
        $import = $repository->findTheLatest();

        $cache = new FilesystemAdapter();
        $data = $cache->get('data_essence', function (ItemInterface $item) {
            return null;
        });
        return $this->render('essence/index.html.twig', ['data' => $data, 'import' => current($import)]);
    }
}
