<?php

declare(strict_types=1);

namespace App\Model\Import;

/**
 * Interface ImportProcessorInterface
 * @package App\Model\Import;
 */
interface ImportProcessorInterface
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function process($data = []);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function setDataResponse($data = []);

    /**
     * @return mixed
     */
    public function getDataResponse();
}
