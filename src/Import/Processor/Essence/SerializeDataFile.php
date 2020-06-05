<?php

declare(strict_types=1);


namespace App\Import\Processor\Essence;

use App\Import\Processor\BaseProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Class SerializeDataFile
 *
 * @package App\Import\Processor\Essence
 *
 * @author  Sébatien Framinet <sebastien.framinet@asdoria.com>
 *
 */
class SerializeDataFile extends BaseProcessor
{
    /** @var string $publicPath */
    protected $publicPath;

    /** @var Filesystem */
    protected $filesystem;

    /** @var FilesystemAdapter */
    private $cache;

    /**
     * SaveDataFile constructor.
     *
     * @param string            $publicPath
     * @param Filesystem        $filesystem
     * @param FilesystemAdapter $cache
     */
    public function __construct(string $publicPath, Filesystem $filesystem)
    {
        $this->publicPath = $publicPath . DIRECTORY_SEPARATOR . 'public';
        $this->filesystem = $filesystem;
        $this->cache      = new FilesystemAdapter();
    }

    /**
     * @param array $data
     *
     * @return array|mixed
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function process($data = [])
    {
        parent::process($data);

        $dataResponse = $this->getDataResponse();

        if (!$this->dataIsValid()) {
            return $dataResponse;
        }

        $filePath = $dataResponse['fullPath'];
        $xml      = simplexml_load_file($filePath);
        $json     = json_encode($xml);

        $this->cache->delete('data_essence');
        $this->cache->get('data_essence', function (ItemInterface $item) use ($json) {
            return $json;
        });

        $dataResponse['data_json'] = $json;

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
