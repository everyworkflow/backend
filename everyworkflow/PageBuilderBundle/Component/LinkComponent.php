<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Component;

class LinkComponent implements ComponentInterface
{
    public const KEY_LABEL = 'label';
    public const KEY_URL = 'url';
    public const KEY_IS_EXTERNAL = 'is_external';
    public const KEY_CSS_CLASS = 'css_class';

    protected ?array $data = null;

    public function setLabel(string $label): self
    {
        $this->data[self::KEY_LABEL] = $label;

        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->data[self::KEY_URL] = $url;

        return $this;
    }

    public function setIsExternal(bool $isExternal): self
    {
        $this->data[self::KEY_IS_EXTERNAL] = $isExternal;

        return $this;
    }

    public function setCssClass(string $class): self
    {
        $this->data[self::KEY_CSS_CLASS] = $class;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }
}
