<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DeveloperBundle\Model;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

class Stub implements StubInterface
{
    public function __construct(
        protected DataObjectInterface $dataObject
    ) {
    }

    public function setStubPath(string $stubPath): self
    {
        $this->dataObject->setData(self::KEY_STUB_PATH, $stubPath);

        return $this;
    }

    public function getStubPath(): ?string
    {
        return $this->dataObject->getData(self::KEY_STUB_PATH);
    }

    public function setFileName(string $fileName): self
    {
        $this->dataObject->setData(self::KEY_FILE_NAME, $fileName);

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->dataObject->getData(self::KEY_FILE_NAME);
    }

    public function setFileExtension(string $fileExtension): self
    {
        $this->dataObject->setData(self::KEY_FILE_EXTENSION, $fileExtension);

        return $this;
    }

    public function getFileExtension(): ?string
    {
        return $this->dataObject->getData(self::KEY_FILE_EXTENSION);
    }

    public function setFileDir(string $fileDir): self
    {
        $this->dataObject->setData(self::KEY_FILE_DIR, $fileDir);

        return $this;
    }

    public function getFileDir(): ?string
    {
        return $this->dataObject->getData(self::KEY_FILE_DIR);
    }

    public function setFileNamespace(string $fileNamespace): self
    {
        $this->dataObject->setData(self::KEY_FILE_NAMESPACE, $fileNamespace);

        return $this;
    }

    public function getFileNamespace(): ?string
    {
        return $this->dataObject->getData(self::KEY_FILE_NAMESPACE);
    }

    public function setBundleNamespace(string $bundleNamespace): self
    {
        $this->dataObject->setData(self::KEY_BUNDLE_NAMESPACE, $bundleNamespace);

        return $this;
    }

    public function getBundleNamespace(): ?string
    {
        return $this->dataObject->getData(self::KEY_BUNDLE_NAMESPACE);
    }

    public function setAppNamespace(string $appNamespace): self
    {
        $this->dataObject->setData(self::KEY_APP_NAMESPACE, $appNamespace);

        return $this;
    }

    public function getAppNamespace(): ?string
    {
        return $this->dataObject->getData(self::KEY_APP_NAMESPACE);
    }

    public function setGenerateFileHeader(string $makeAuthor): self
    {
        $this->dataObject->setData(self::KEY_GENERATE_FILE_HEADER, $makeAuthor);

        return $this;
    }

    public function getGenerateFileHeader(): string
    {
        return $this->dataObject->getData(self::KEY_GENERATE_FILE_HEADER);
    }

    public function toArray(): array
    {
        return $this->dataObject->toArray();
    }

    public function setData(string $key, mixed $val): self
    {
        $this->dataObject->setData($key, $val);

        return $this;
    }

    public function setDataIfNot(string $key, mixed $val): self
    {
        $this->dataObject->setDataIfNot($key, $val);

        return $this;
    }

    public function getData(string $key): mixed
    {
        return $this->dataObject->getData($key);
    }

    public function resetData(array $data): self
    {
        $this->dataObject->resetData($data);

        return $this;
    }
}
