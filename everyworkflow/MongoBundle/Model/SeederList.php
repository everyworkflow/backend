<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MongoBundle\Model;

use EveryWorkflow\MongoBundle\Support\SeederInterface;

class SeederList implements SeederListInterface
{
    /**
     * All the seeder types, injected via service
     * @param $seeders SeederInterface[]
     */
    public function __construct(
        protected iterable $seeders = []
    ) {
    }

    /**
     * @return SeederInterface[]
     */
    public function getSortedList(): array
    {
        $sortedSeederNames = [];

        $seeders = [];
        foreach ($this->seeders as $seeder) {
            if ($seeder instanceof SeederInterface) {
                $class = get_class($seeder);
                $classNameArr = explode('\\', $class);
                $fileName = $classNameArr[count($classNameArr) - 1];
                $sortedSeederNames[$fileName][] = $class;
                $seeders[$class] = $seeder;
            }
        }

        ksort($sortedSeederNames);

        $sortedSeeders = [];
        foreach ($sortedSeederNames as $fileName => $classes) {
            foreach ($classes as $class) {
                $sortedSeeders[$class] = $seeders[$class];
            }
        }

        return $sortedSeeders;
    }
}
