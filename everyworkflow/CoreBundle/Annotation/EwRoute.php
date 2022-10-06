<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Annotation;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Annotation class for @EwRoute().
 *
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class EwRoute extends Route
{
    public function __construct(
        string|array $path = null,
        private ?string $name = null,
        private array $requirements = [],
        private array $options = [],
        private array $defaults = [],
        private ?string $host = null,
        array|string $methods = [],
        array|string $schemes = [],
        private ?string $condition = null,
        private ?int $priority = null,
        string $locale = null,
        string $format = null,
        bool $utf8 = null,
        bool $stateless = null,
        private ?string $env = null,
        private string|array|null $permissions = null,
        private string|bool|array|null $swagger = null
    ) {
        parent::__construct(
            $path,
            $name,
            $requirements,
            $options,
            $defaults,
            $host,
            $methods,
            $schemes,
            $condition,
            $priority,
            $locale,
            $format,
            $utf8,
            $stateless
        );
    }
}
