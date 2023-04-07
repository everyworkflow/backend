<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DeveloperBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'everyworkflow:info')]
class InfoCommand extends Command
{
    protected function configure(): void
    {
        $this->setDescription('Information about every workflow project');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputOutput = new SymfonyStyle($input, $output);

        $inputOutput->title('EveryWorkflow v0.1.0-alpha');

        $inputOutput->block([
            '- Some info goes here',
            '- Some info goes here',
            '- Some info goes here',
            '- Some info goes here',
            '- Some info goes here',
            '- Some info goes here',
            '- Some info goes here',
        ]);

        $inputOutput->comment('End of info');

        return Command::SUCCESS;
    }
}
