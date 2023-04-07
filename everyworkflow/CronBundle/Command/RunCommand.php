<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CronBundle\Command;

use EveryWorkflow\CronBundle\Model\CronJobListInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'cron:run')]
class RunCommand extends Command
{
    public const KEY_JOBS = 'jobs';
    public const KEY_FORCED = 'forced';

    public function __construct(
        protected CronJobListInterface $cronJobList,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription('Execute cron')
            ->setHelp('Eg: bin/console cron:run'.PHP_EOL
                .'Eg: bin/console cron:run -j job_code -f')
            ->addOption(self::KEY_JOBS, 'j', InputOption::VALUE_OPTIONAL, 'Cron Job Codes')
            ->addOption(self::KEY_FORCED, 'f', InputOption::VALUE_NEGATABLE, 'Forced', false);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputOutput = new SymfonyStyle($input, $output);
        $jobText = $input->getOption(self::KEY_JOBS) ?? '';
        if ('' === $jobText) {
            $jobs = [];
        } else {
            $jobs = explode(',', $jobText);
        }
        $isForced = $input->getOption(self::KEY_FORCED);

        try {
            $this->cronJobList->execute($jobs, $isForced);
        } catch (\Exception $e) {
            $inputOutput->text('Error: '.$e->getMessage());
        }

        return Command::SUCCESS;
    }
}
