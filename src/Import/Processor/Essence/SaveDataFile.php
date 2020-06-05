<?php

declare(strict_types=1);


namespace App\Import\Processor\Essence;

use App\Entity\HistoryImportEssenceData;
use App\Import\Processor\BaseProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class SaveDataFile
 *
 * @package App\Import\Processor\Essence
 *
 * @author  Sébatien Framinet <sebastien.framinet@asdoria.com>
 *
 */
class SaveDataFile extends BaseProcessor
{
    /** @var string $publicPath */
    protected $publicPath;

    /** @var Filesystem */
    protected $filesystem;

    /** @var EntityManagerInterface */
    protected $em;

    /**
     * SaveDataFile constructor.
     *
     * @param string                 $publicPath
     * @param Filesystem             $filesystem
     * @param EntityManagerInterface $em
     */
    public function __construct(string $publicPath, Filesystem $filesystem, EntityManagerInterface $em)
    {
        $this->publicPath = $publicPath . DIRECTORY_SEPARATOR . 'public';
        $this->filesystem = $filesystem;
        $this->em         = $em;
    }

    /**
     * @param array $data
     *
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function process($data = [])
    {
        parent::process($data);

        $dataResponse = $this->getDataResponse();

        if (!$this->dataIsValid()) {
            return $dataResponse;
        }

        $filePath = $dataResponse['publicPath'];
        $history  = new HistoryImportEssenceData();
        $history->setPath($filePath);
        $this->em->persist($history);
        $this->em->flush();

        return $dataResponse;
    }

    /**
     * @return bool
     */
    public function dataIsValid()
    {
        $dataResponse = $this->getDataResponse();
        if (empty($dataResponse['publicPath'])) {
            return false;
        }

        $filePath = $dataResponse['fullPath'];
        if (!$this->filesystem->exists($filePath)) {
            return false;
        }

        return true;
    }


}
