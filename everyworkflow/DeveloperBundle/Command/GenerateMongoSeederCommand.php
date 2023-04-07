<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DeveloperBundle\Command;

use Carbon\Carbon;
use EveryWorkflow\DeveloperBundle\Factory\StubFactoryInterface;
use EveryWorkflow\DeveloperBundle\Model\StubGeneratorInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'generate:mongo:seeder')]
class GenerateMongoSeederCommand extends Command
{
    public const KEY_FILE = 'file';
    public const KEY_BUNDLE = 'bundle';

    protected StubFactoryInterface $stubFactory;
    protected StubGeneratorInterface $stubGenerator;

    public function __construct(
        StubFactoryInterface $stubFactory,
        StubGeneratorInterface $stubGenerator,
        string $name = null
    ) {
        parent::__construct($name);
        $this->stubFactory = $stubFactory;
        $this->stubGenerator = $stubGenerator;
    }

    /**
     * @throws \Exception
     */
    protected function configure(): void
    {
        $this->setDescription('Generates mongo seeder class')
            ->setHelp('Eg: bin/console generate:mongo:seeder UserDataSeeder UserBundle')
            ->addArgument(self::KEY_FILE, InputArgument::REQUIRED, 'Seeder file')
            ->addArgument(self::KEY_BUNDLE, InputArgument::REQUIRED, 'Bundle dir');
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputOutput = new SymfonyStyle($input, $output);

        $inputOutput->title('Generate Mongo Seeder');

        /** @var string $fileName */
        $fileName = $input->getArgument(self::KEY_FILE);
        $fileName = preg_replace('/[A-Z]/', '_$0', $fileName);
        $fileName = ltrim($fileName, '_');
        if (!strpos($fileName, 'Seeder')) {
            $fileName .= '_Seeder';
        }
        $fileName = 'Mongo_' . Carbon::now()->format('Y_m_d_H_i_s') . '_' . $fileName;

        /** @var string $bundleName */
        $bundleName = $input->getArgument(self::KEY_BUNDLE);

        /* Preparing interfaceStub for generation */
        $stub = $this->stubFactory->create(
            $fileName,
            'Seeder',
            $bundleName
        );
        $stub->setStubPath(__DIR__ . '/../Resources/stub/Generate/Seeder/SampleSeeder.php.stub');

        $interfaceFilePath = $this->stubGenerator->generate($stub);
        $inputOutput->success('Successfully generated mongo seeder:- ' . $interfaceFilePath);
        $inputOutput->newLine(2);

        return Command::SUCCESS;
    }
}
