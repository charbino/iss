<?php

namespace App\Command;

use App\Import\ImportProcessorChaining;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Class ImportEssence
 *
 * @package App\Command
 *
 * @author  Sébatien Framinet <sebastien.framinet@asdoria.com>
 *
 */
class ImportEssence extends Command
{

    protected static $defaultName = 'essence:import';

    /**
     * @var SymfonyStyle
     */
    private $io;
    /**
     * @var ImportProcessorChaining
     */
    private $processor;

    /**
     * ImportEssence constructor.
     *
     * @param ImportProcessorChaining $processor
     */
    public function __construct(ImportProcessorChaining $processor)
    {
        $this->processor = $processor;
        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Import essence data')
            ->setHelp('This command import data essence in project');
    }

    /**
     * This optional method is the first one executed for a command after configure()
     * and is useful to initialize properties based on the input arguments and options.
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        // SymfonyStyle is an optional feature that Symfony provides so you can
        // apply a consistent look to the commands of your application.
        // See https://symfony.com/doc/current/console/style.html
        $this->io = new SymfonyStyle($input, $output);
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('essence-import');

        $result = [];
        $this->processor->chaining($result);

        $this->io->success(sprintf('All data was successfully import'));

        $event = $stopwatch->stop('essence-import');
        if ($output->isVerbose()) {
            $this->io->comment(sprintf('Elapsed time: %.2f ms / Consumed memory: %.2f MB', $event->getDuration(), $event->getMemory() / (1024 ** 2)));
        }
    }

}
