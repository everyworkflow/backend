<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\IndexerBundle\Model;

use EveryWorkflow\IndexerBundle\Repository\IndexerRepositoryInterface;
use EveryWorkflow\IndexerBundle\Support\IndexerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Process\Process;

class IndexerList implements IndexerListInterface
{
    protected array $processList = [];

    /**
     * All the indexes, injected via service.
     *
     * @var IndexerInterface[]
     */
    protected iterable $indexers;

    public function __construct(
        protected IndexerRepositoryInterface $indexerRepository,
        protected EventDispatcherInterface $eventDispatcher,
        iterable $indexers = []
    ) {
        $this->indexers = $indexers;
    }

    public function invalid(array $indexCodes = [], $isForced = false): void
    {
        $indexCodeCount = count($indexCodes);
        foreach ($this->indexers as $indexer) {
            $indexCode = $this->getIndexerCode($indexer);
            if (0 === $indexCodeCount) {
                echo '- Invalid: ' . $indexCode . ' at ' . date('Y-m-d H:i:s') . PHP_EOL;
                $indexer->invalid();
            } else {
                if (in_array($indexCode, $indexCodes, true)) {
                    echo '- Invalid: ' . $indexCode . ' at ' . date('Y-m-d H:i:s') . PHP_EOL;
                    $indexer->invalid();
                }
            }
        }
    }

    public function reindex(array $indexCodes = [], $isForced = false): void
    {
        $this->invalid($indexCodes, $isForced);
        $this->index($indexCodes, $isForced);
    }

    public function index(array $indexCodes = [], $isForced = false): void
    {
        $indexCodeCount = count($indexCodes);
        foreach ($this->indexers as $indexer) {
            if (0 === $indexCodeCount) {
                if ($isForced) {
                    $this->indexOne($indexer, $isForced, true);
                } else {
                    $this->indexOne($indexer);
                }
            } else {
                $indexCode = $this->getIndexerCode($indexer);
                if (in_array($indexCode, $indexCodes, true)) {
                    $this->indexOne($indexer, $isForced, true);
                }
            }
        }
        $this->manageRunningProcess();
    }

    protected function getIndexerCode(IndexerInterface $item): string
    {
        $code = $item->getCode() ?? '';
        if ('' === $code) {
            $className = get_class($item);
            $code = str_replace('\\', '_', $className);
        }

        return $code;
    }

    public function indexOne(IndexerInterface $item, $isForced = false, $canExecute = false): void
    {
        $code = $this->getIndexerCode($item);

        try {
            $indexer = $this->indexerRepository->findOne(['code' => $code]);
        } catch (\Exception $e) {
            $indexer = $this->indexerRepository->create([
                'code' => $code,
                'status' => 'enable',
                'class_name' => get_class($item),
                'schedule_at' => null,
            ]);
        }

        if ('enable' !== $indexer->getData('status')) {
            return;
        }

        if (!$isForced && in_array($indexer->getData('state'), ['processing'], true)) {
            return;
        }

        if ($canExecute) {
            $indexer->setData('state', 'processing');
            $indexer->setData('error_message', '');
            $indexer = $this->indexerRepository->saveOne($indexer);
            echo '-- Indexing: ' . $code . ' at ' . date('Y-m-d H:i:s') . PHP_EOL;
            $indexer->setData('starting_at', date('Y-m-d H:i:s'));

            try {
                $this->eventDispatcher->dispatch(
                    $indexer,
                    'indexer_' . $code . '_execute_before'
                );
                $item->index();
                echo '-- Completed: ' . $code . ' at ' . date('Y-m-d H:i:s') . PHP_EOL;
                $indexer->setData('completed_at', date('Y-m-d H:i:s'));
                $this->eventDispatcher->dispatch(
                    $indexer,
                    'indexer_' . $code . '_execute_after'
                );
                $indexer->setData('state', 'completed');
                $indexer->setData('error_message', '');
            } catch (\Exception $e) {
                echo '-- Error: ' . $code . ' at ' . date('Y-m-d H:i:s') . ' Message: ' . $e->getMessage() . PHP_EOL;
                $indexer->setData('completed_at', date('Y-m-d H:i:s'));
                $indexer->setData('state', 'error');
                $indexer->setData('error_message', $e->getMessage());
            }
        } else {
            $indexer->setData('state', 'starting');
            $indexer->setData('error_message', '');

            $commandArray = ['bin/console', 'indexer:index', '-c', $code];
            if ($isForced) {
                $commandArray[] = '-f';
            }
            $process = new Process($commandArray);
            $process->start();

            $indexer->setData('process_id', $process->getPid());

            $this->processList[$code] = $process;
        }

        $this->indexerRepository->saveOne($indexer);
    }

    protected function manageRunningProcess(): void
    {
        foreach ($this->processList as $code => $process) {
            $process->wait();
            $indexer = $this->indexerRepository->findOne(['code' => $code]);
            $logMsg = '- Index: ' . $code . PHP_EOL;
            $logMsg .= (string) $process->getOutput() . PHP_EOL;
            $indexer->setData('log', $logMsg);
            $indexer->setData('process_id', null);
            echo $logMsg;
            $this->indexerRepository->saveOne($indexer);
        }
    }
}
