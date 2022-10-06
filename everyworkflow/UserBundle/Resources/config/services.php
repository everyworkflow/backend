<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySource;
use EveryWorkflow\DataGridBundle\Model\DataGridConfig;
use EveryWorkflow\UserBundle\DataGrid\UserDataGrid;
use EveryWorkflow\UserBundle\Repository\UserRepository;

return function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('EveryWorkflow\\UserBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Tests}');

//    $services->set('MongoDB_User_Connection', \EveryWorkflow\MongoBundle\Model\MongoConnection::class)
//        ->arg('$mongoUri', '%env(MONGO_URI)%')
//        ->arg('$mongoDb', 'everyworkflow_user');
//    $services->set(
//        'BaseDocumentRepository_Mongo_User_Connection',
//        \EveryWorkflow\MongoBundle\Repository\BaseDocumentRepository::class
//    )->arg('$mongoConnection', service('MongoDB_User_Connection'));
//    $services->set(\EveryWorkflow\UserBundle\Repository\UserRepository::class)
//        ->arg('$documentRepository', service('BaseDocumentRepository_Mongo_User_Connection'));

    $services->set('ew_user_grid_config', DataGridConfig::class);
    $services->set('ew_user_grid_source', RepositorySource::class)
        ->arg('$baseRepository', service(UserRepository::class))
        ->arg('$dataGridConfig', service('ew_user_grid_config'));
    $services->set(UserDataGrid::class)
        ->arg('$source', service('ew_user_grid_source'))
        ->arg('$dataGridConfig', service('ew_user_grid_config'));
};
