<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle\Model;

use EveryWorkflow\CoreBundle\Model\DataObject;

class SwaggerData extends DataObject implements SwaggerDataInterface
{
    public function setOpenApi(string $openApi): self
    {
        $this->setData(self::KEY_OPENAPI, $openApi);

        return $this;
    }

    public function getOpenApi(): ?string
    {
        return $this->getData(self::KEY_OPENAPI);
    }

    public function setInfo(array $info): self
    {
        $this->setData(self::KEY_INFO, $info);

        return $this;
    }

    public function getInfo(): ?array
    {
        return $this->getData(self::KEY_INFO);
    }

    public function setServers(string $servers): self
    {
        $this->setData(self::KEY_SERVERS, $servers);

        return $this;
    }

    public function getServers(): ?array
    {
        return $this->getData(self::KEY_SERVERS);
    }

    public function setTags(array $tags): self
    {
        $this->setData(self::KEY_TAGS, $tags);

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->getData(self::KEY_TAGS);
    }

    public function setPaths(array $paths): self
    {
        $this->setData(self::KEY_PATHS, $paths);

        return $this;
    }

    public function getPaths(): ?array
    {
        return $this->getData(self::KEY_PATHS);
    }

    public function setComponents(array $components): self
    {
        $this->setData(self::KEY_COMPONENTS, $components);

        return $this;
    }

    public function getComponents(): ?array
    {
        return $this->getData(self::KEY_COMPONENTS);
    }

    public function setExternalDocs(array $externalDocs): self
    {
        $this->setData(self::KEY_EXTERNAL_DOCS, $externalDocs);

        return $this;
    }

    public function getExternalDocs(): ?array
    {
        return $this->getData(self::KEY_EXTERNAL_DOCS);
    }
}
