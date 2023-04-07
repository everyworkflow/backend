<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\IndexerBundle\Command;

use EveryWorkflow\IndexerBundle\Model\IndexerListInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'indexer:reindex')]
class ReindexCommand extends Command
{
    public const KEY_INDEX_CODES = 'index_codes';
    public const KEY_FORCED = 'forced';

    public function __construct(
        protected IndexerListInterface $indexerList,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription('Invalid and generate indexer index')
            ->setHelp('Eg: bin/console indexer:reindex' . PHP_EOL
                . 'Eg: bin/console indexer:reindex -c index_code -f')
            ->addOption(self::KEY_INDEX_CODES, 'c', InputOption::VALUE_OPTIONAL, 'Index Codes')
            ->addOption(self::KEY_FORCED, 'f', InputOption::VALUE_NEGATABLE, 'Forced', false);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputOutput = new SymfonyStyle($input, $output);
        $indexCodesText = $input->getOption(self::KEY_INDEX_CODES) ?? '';
        if ('' === $indexCodesText) {
            $indexCodes = [];
        } else {
            $indexCodes = explode(',', $indexCodesText);
        }
        $isForced = $input->getOption(self::KEY_FORCED);

        try {
            $this->indexerList->reindex($indexCodes, $isForced);
        } catch (\Exception $e) {
            $inputOutput->text('Error: ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
