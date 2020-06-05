<?php

declare(strict_types=1);

namespace App\Import\Processor;

use App\Model\Import\ImportProcessorInterface;

/**
 * Class BaseProcessor
 *
 * @package App\Import\Processor
 *
 * @author  Sébatien Framinet <sebastien.framinet@asdoria.com>
 *
 */
abstract class BaseProcessor implements ImportProcessorInterface
{

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var []
     */
    protected $dataResponse;


    /**
     * @param array $data
     *
     * @return array
     */
    public function process($data = [])
    {
        $this->data = $data;

        return $this->data;
    }


    /**
     * @param array $data
     *
     * @return mixed
     */
    public function setDataResponse($data = [])
    {
        $this->dataResponse = $data;
    }

    /**
     * @return mixed
     */
    public function getDataResponse()
    {
        return $this->dataResponse;
    }

    /**
     * @param string $publicPath
     *
     * @return string
     */
    public function getPathDataEssence(string $publicPath)
    {
        return $publicPath . DIRECTORY_SEPARATOR . $this->getPathDataEssencePublic();
    }

    /**
     * @return string
     */
    public function getPathDataEssencePublic()
    {
        return 'essence/data/instantane';
    }
}
