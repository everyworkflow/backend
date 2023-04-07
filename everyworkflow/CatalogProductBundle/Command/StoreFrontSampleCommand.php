<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogProductBundle\Command;

use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'sample:store-front')]
class StoreFrontSampleCommand extends Command
{
    public const KEY_TYPE = 'type';

    public function __construct(
        protected CatalogProductRepositoryInterface $catalogProductRepository,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription('Add/Remove store front sample data')
            ->setHelp('bin/console sample:store-front add')
            ->addArgument(self::KEY_TYPE, InputArgument::REQUIRED, 'Type');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputOutput = new SymfonyStyle($input, $output);

        $type = $input->getArgument(self::KEY_TYPE, 'add');

        if ('remove' === $type) {
            $this->catalogProductRepository->getCollection()->drop();
            $inputOutput->text('Sample data removed');

            return Command::SUCCESS;
        }

        $itemData = [];

        for ($i = 1; $i < 350; ++$i) {
            $itemData[] = [
                'status' => 'enable',
                'name' => 'Product Name - '.$i,
                'sku' => 'sku-'.$i,
                'price' => 5000 + $i,
                'quantity' => 100 + $i,
                'short_description' => 'This is just a short description. '.$i,
                'description' => 'This is just a description. '.$i,
                'meta_title' => 'Product Name - '.$i,
                'url_key' => 'sku-'.$i,
            ];
        }

        foreach ($itemData as $item) {
            $product = $this->catalogProductRepository->create($item);
            $this->catalogProductRepository->saveOne($product);
        }

        $inputOutput->text('Sample data added');

        return Command::SUCCESS;
    }
}
