<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\AdminPanelBundle\Seeder;

use EveryWorkflow\MongoBundle\Support\SeederInterface;
use EveryWorkflow\UserBundle\Seeder\Mongo_2021_11_21_11_54_27_User_Data_Seeder;
use EveryWorkflow\PageBundle\Seeder\Mongo_2021_12_16_07_39_20_Page_Data_Seeder;
use EveryWorkflow\MenuBundle\Seeder\Mongo_2022_01_02_09_17_40_Menu_Seeder;

class Mongo_2023_01_01_00_00_00_Basic_Seeder implements SeederInterface
{
    public function __construct(
        protected Mongo_2021_11_21_11_54_27_User_Data_Seeder $userDataSeeder,
        protected Mongo_2021_12_16_07_39_20_Page_Data_Seeder $pageDataSeeder,
        protected Mongo_2022_01_02_09_17_40_Menu_Seeder $menuSeeder
    ) {
    }

    public function seed(): bool
    {
        $this->userDataSeeder->seed();
        $this->pageDataSeeder->seed();
        $this->menuSeeder->seed();
        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->userDataSeeder->rollback();
        $this->pageDataSeeder->rollback();
        $this->menuSeeder->rollback();
        return self::SUCCESS;
    }
}
