<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Component;

class ImageComponent implements ComponentInterface
{
    public const KEY_URL = 'url';
    public const KEY_ALT = 'alt';
    public const KEY_CSS_CLASS = 'css_class';

    protected ?array $data = null;

    public function setUrl(string $url): self
    {
        $this->data[self::KEY_URL] = $url;

        return $this;
    }

    public function setAlt(string $altText): self
    {
        $this->data[self::KEY_ALT] = $altText;

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
