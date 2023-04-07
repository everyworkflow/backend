<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MongoBundle\Command;

use EveryWorkflow\MongoBundle\Repository\SeederRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'mongo:seed:log')]
class MongoSeedLogCommand extends Command
{
    public function __construct(
        protected SeederRepositoryInterface $seederRepository,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription('Shows mongo seeder log')
            ->setHelp('This command will print mongo seeders');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputOutput = new SymfonyStyle($input, $output);

        $inputOutput->title('Mongo seeder log');

        $table = new Table($output);
        $table->setHeaders(['UUID', 'Bundle Name', 'File Name', 'Seeder Class', 'Seeded At']);

        /* Adding seeder data to table format */
        $seeders = $this->seederRepository->find();
        foreach ($seeders as $seeder) {
            $table->addRow([
                $seeder->getId(),
                $seeder->getBundleName(),
                $seeder->getFileName(),
                $seeder->getClass(),
                $seeder->getSeededAt(),
            ]);
        }

        $table->render();
        $inputOutput->newLine();

        return Command::SUCCESS;
    }
}
