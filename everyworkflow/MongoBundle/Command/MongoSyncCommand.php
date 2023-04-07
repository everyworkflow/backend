<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MongoBundle\Command;

use EveryWorkflow\MongoBundle\Model\SyncListInterface;
use EveryWorkflow\MongoBundle\Support\SyncInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'mongo:sync')]
class MongoSyncCommand extends Command
{
    public function __construct(
        protected SyncListInterface $syncList,
        string $name = null
    ) {
        parent::__construct($name);
    }


    protected function configure(): void
    {
        $this->setDescription('Sync mongo database')
            ->setHelp('This command will sync mongo database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputOutput = new SymfonyStyle($input, $output);

        $inputOutput->title('EveryWorkflow Mongo Sync');

        $sortedSyncList = $this->syncList->getSortedList();
        if (!count($sortedSyncList)) {
            $inputOutput->warning('No mongo sync found!');

            return Command::FAILURE;
        }

        foreach ($sortedSyncList as $obj) {
            if ($obj instanceof SyncInterface) {
                $class = get_class($obj);
                $inputOutput->success('- Running mongo sync ' . $class);

                try {
                    $obj->sync();
                } catch (\Exception $e) {
                    $inputOutput->error($e->getMessage());
                }
            }
        }

        return Command::SUCCESS;
    }
}
