<?php

declare(strict_types=1);


namespace App\Import\Processor\Essence;

use App\Client\EssenceClient;
use App\Import\Processor\BaseProcessor;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class DownloadDataFile
 *
 * @package App\Import\Processor\Essence
 *
 * @author  Sébatien Framinet <sebastien.framinet@asdoria.com>
 *
 */
class DownloadDataFile extends BaseProcessor
{

    /** @var EssenceClient $client */
    private $client;

    /** @var string $publicPath */
    private $publicPath;

    /** @var Filesystem */
    private $filesystem;

    /**
     * DownloadDataFile constructor.
     *
     * @param EssenceClient $client
     * @param string        $publicPath
     * @param Filesystem    $filesystem
     */
    public function __construct(EssenceClient $client, string $publicPath, Filesystem $filesystem)
    {
        $this->client     = new $client();
        $this->publicPath = $publicPath . DIRECTORY_SEPARATOR . 'public';
        $this->filesystem = $filesystem;
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
        $fullPath     = $this->getPath();
        $file         = $this->getFile($fullPath);
        $response     = $this->client->getInstantane($file);

        if ($response->getStatusCode() == 200) {
            $dataResponse['file'] = $fullPath;
        }

        return $dataResponse;
    }

    /**
     * @return bool|resource
     */
    protected function getFile(string $fullPath)
    {
        $resource = fopen($fullPath, 'w');

        return $resource;
    }

    /**
     * @return string
     */
    protected function getPath(): string
    {
        $filename = 'instantane.zip';
        $path     = $this->getPathDataEssence($this->publicPath);
        if (!$this->filesystem->exists($path)) {
            $this->filesystem->mkdir($path, 0755);
        }
        $fullPath = $path . DIRECTORY_SEPARATOR . $filename;

        return $fullPath;
    }
}
