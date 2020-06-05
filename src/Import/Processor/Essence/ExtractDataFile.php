<?php

declare(strict_types=1);


namespace App\Import\Processor\Essence;

use App\Import\Processor\BaseProcessor;
use Symfony\Component\Filesystem\Filesystem;
use ZipArchive;

/**
 * Class ExtractDataFile
 *
 * @package App\Import\Processor\Essence
 *
 * @author  Sébatien Framinet <sebastien.framinet@asdoria.com>
 *
 */
class ExtractDataFile extends BaseProcessor
{
    /** @var string $publicPath */
    private $publicPath;

    /** @var Filesystem */
    private $filesystem;

    /**
     * ExtractDataFile constructor.
     *
     * @param string     $publicPath
     * @param Filesystem $filesystem
     */
    public function __construct(string $publicPath, Filesystem $filesystem)
    {
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

        if (!$this->dataIsValid()) {
            return $dataResponse;
        }

        $filePath = $dataResponse['file'];

        $zip = new ZipArchive;
        $res = $zip->open($filePath);
        if ($res !== TRUE) {
            return $dataResponse;
        }
        $zipFilePath = $this->getPathDataEssence($this->publicPath);
        $zip->extractTo($zipFilePath);

        if ($zip->numFiles === 1) {
            $filename = $zip->getNameIndex(0);
            $fileinfo = pathinfo($filename);

            $fullPath = $zipFilePath . DIRECTORY_SEPARATOR . $filename;

            $newFileName = date('YmdHis') . '.' . $fileinfo['extension'];
            $newFullPath = $zipFilePath . DIRECTORY_SEPARATOR . $newFileName;

            $this->filesystem->copy($fullPath, $newFullPath);
            $this->filesystem->remove($fullPath);

            $dataResponse['fullPath']   = $newFullPath;
            $dataResponse['publicPath'] = $this->getPathDataEssencePublic() . $newFileName;
        }

        $zip->close();

        return $dataResponse;
    }

    /**
     * @return bool
     */
    public function dataIsValid()
    {
        $dataResponse = $this->getDataResponse();
        if (empty($dataResponse['file'])) {
            return false;
        }

        $filePath = $dataResponse['file'];
        if (!$this->filesystem->exists($filePath)) {
            return false;
        }

        return true;
    }


}
