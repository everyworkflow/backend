<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\DataGridBundle\Model\Collection\ArraySourceInterface;
use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySourceInterface;
use Symfony\Component\HttpFoundation\Request;

class DataGrid implements DataGridInterface
{
    protected ?Request $request = null;
    protected array $filters = [];
    protected array $options = [];

    public function __construct(
        protected DataObjectInterface $dataObject,
        protected DataGridConfigInterface $dataGridConfig,
        protected FormInterface $form,
        protected ArraySourceInterface $source
    ) {
    }

    public function getConfig(): DataGridConfigInterface
    {
        return $this->dataGridConfig;
    }

    public function setConfig(DataGridConfigInterface $dataGridConfig): self
    {
        $this->dataGridConfig = $dataGridConfig;

        return $this;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }

    public function setForm(FormInterface $form): self
    {
        $this->form = $form;

        return $this;
    }

    public function getSource(): ArraySourceInterface
    {
        if ($this->source instanceof RepositorySourceInterface) {
            $this->source->setForm($this->getForm());
        }
        if ($this->getRequest()) {
            $this->source->setRequest($this->getRequest());
        }
        return $this->source;
    }

    public function setSource(ArraySourceInterface $collectionSource): self
    {
        $this->source = $collectionSource;

        return $this;
    }

    public function setFromRequest(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function setFilters(array $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    public function getFilters(): array
    {
        if ($this->getRequest()) {
            return $this->getSource()
                ->getParameter()
                ->setFilters($this->filters)
                ->setOptions($this->options)
                ->setFromRequest($this->getRequest())
                ->getFilters();
        }

        return $this->filters;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions(): array
    {
        if ($this->getRequest()) {
            return $this->getSource()
                ->getParameter()
                ->setFilters($this->filters)
                ->setOptions($this->options)
                ->setFromRequest($this->getRequest())
                ->getOptions();
        }

        return $this->options;
    }

    public function toArray(): array
    {
        $form = $this->getForm();
        $source = $this->getSource();
        $config = $this->getConfig();

        if ($source instanceof RepositorySourceInterface && $this->getRequest()) {
            $source->getParameter()
                ->setFilters($this->getFilters())
                ->setOptions($this->getOptions())
                ->setFromRequest($this->getRequest());
        }

        $data = [
            self::KEY_DATA_COLLECTION => $source->toArray()
        ];
        if ($this->request->get('for') === 'data-grid') {
            $data[self::KEY_DATA_GRID_CONFIG] = $config->toArray();
            $data[self::KEY_DATA_FORM] = $form->toArray();
        }
        return $data;
    }
}
