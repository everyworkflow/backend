<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

interface TextFieldInterface extends BaseFieldInterface
{
    public const SIZE_SMALL = 'small';
    public const SIZE_NORMAL = ''; // default
    public const SIZE_LARGE = 'large';

    public const INPUT_TYPE_TEXT = 'text'; // default
    public const INPUT_TYPE_EMAIL = 'email';
    public const INPUT_TYPE_PASSWORD = 'password';
    public const INPUT_TYPE_NUMBER = 'number';
    public const INPUT_TYPE_FILE = 'file';
    public const INPUT_TYPE_DATE = 'date';

    public const KEY_INPUT_TYPE = 'input_type';
    public const KEY_SIZE = 'size';
    public const KEY_IS_READONLY_TEXT = 'is_readonly_text';
    public const KEY_PREFIX_TEXT = 'prefix_text';
    public const KEY_SUFFIX_TEXT = 'suffix_text';
    public const KEY_PREFIX_TAB_TEXT = 'prefix_tab_text';
    public const KEY_SUFFIX_TAB_TEXT = 'suffix_tab_text';

    public function getInputType(): ?string;

    public function setInputType(string $inputType): self;

    public function getSize(): ?string;

    public function setSize(string $size): self;

    public function isReadonlyText(): ?bool;

    public function setIsReadonlyText(bool $isReadonlyText): self;

    public function getPrefixText(): ?string;

    public function setPrefixText(string $prefixText): self;

    public function getSuffixText(): ?string;

    public function setSuffixText(string $suffixText): self;

    public function getPrefixTabText(): ?string;

    public function setPrefixTabText(string $prefixTabText): self;

    public function getSuffixTabText(): ?string;

    public function setSuffixTabText(string $suffixTabText): self;
}
