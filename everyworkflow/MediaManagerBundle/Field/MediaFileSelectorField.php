<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MediaManagerBundle\Field;

use EveryWorkflow\DataFormBundle\Field\BaseField;

class MediaFileSelectorField extends BaseField implements MediaFileSelectorFieldInterface
{
    protected string $fieldType = 'media_file_selector_field';

    public function setUploadPath(string $uploadPath): self
    {
        $this->dataObject->setData(self::KEY_UPLOAD_PATH, $uploadPath);
        return $this;
    }

    public function getUploadPath(): ?string
    {
        return $this->dataObject->getData(self::KEY_UPLOAD_PATH);
    }
}
