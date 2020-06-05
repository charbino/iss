<?php

declare(strict_types=1);

namespace App\Import;


use App\Model\Import\ImportProcessorInterface;

/**
 * Class ImportProcessorChaining
 * @package App\Import
 */
class ImportProcessorChaining
{

    /**
     * @var array
     */
    protected $mapping;

    /**
     * ImportProcessorChaining constructor.
     */
    public function __construct()
    {
        $this->mapping = [];
    }

    /**
     * @param ImportProcessorInterface $process
     * @param                          $priority
     */
    public function add(ImportProcessorInterface $process, $priority)
    {
        $this->mapping[$priority] = $process;
    }


    /**
     * @param array  $data
     *
     * @return bool
     */
    public function chaining($data = []): bool
    {
        if (empty($this->mapping)) {

            return false;
        }

        $dataResponse               = [];
        $elements                   = $this->mapping;

        /** @var ImportProcessorInterface $element */
        foreach ($elements as $element) {
            $element->setDataResponse($dataResponse);
            $dataResponse = $element->process($data);
        }

        return true;
    }
}
