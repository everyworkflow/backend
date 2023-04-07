<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\MongoBundle\Command\MongoDatabaseDropCommand;
use EveryWorkflow\MongoBundle\Model\MongoConnection;
use EveryWorkflow\MongoBundle\Model\MigrationList;
use EveryWorkflow\MongoBundle\Model\SeederList;
use EveryWorkflow\MongoBundle\Model\SyncList;

return function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    if (isset($_SERVER['APP_ENV']) && 'test' === $_SERVER['APP_ENV']) {
        $services->public();
    }

    $services->load('EveryWorkflow\\MongoBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Tests,Document/HelperTrait}');

    $services->set(\EveryWorkflow\MongoBundle\Support\Attribute\RepositoryAttribute::class)
        ->autowire(false)
        ->autoconfigure(false);

    $services->set(MongoConnection::class)
        ->arg('$mongoUri', '%env(MONGO_URI)%')
        ->arg('$mongoDb', '%env(MONGO_DB)%');

    $services->set(MongoDatabaseDropCommand::class)
        ->arg('$mongoDb', '%env(MONGO_DB)%');

    $services->set(MigrationList::class)
        ->arg('$migrations', tagged_iterator('everyworkflow.migration'));

    $services->set(SeederList::class)
        ->arg('$seeders', tagged_iterator('everyworkflow.seeder'));

    $services->set(SyncList::class)
        ->arg('$syncList', tagged_iterator('everyworkflow.mongo.sync_list'));

    $services->set(
        \EveryWorkflow\MongoBundle\Repository\BaseRepositoryInterface::class,
        \EveryWorkflow\MongoBundle\Repository\BaseRepository::class
    );
};
