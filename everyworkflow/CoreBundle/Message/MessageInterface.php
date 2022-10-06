<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Message;

interface MessageInterface
{
    /**
     * Default identifier
     */
    public const DEFAULT_IDENTIFIER = 'default_message_identifier';

    /**
     * Error type
     */
    public const TYPE_ERROR = 'error';

    /**
     * Warning type
     */
    public const TYPE_WARNING = 'warning';

    /**
     * Notice type
     */
    public const TYPE_NOTICE = 'notice';

    /**
     * Success type
     */
    public const TYPE_SUCCESS = 'success';

    public function getMessages($clear = false);

    public function getDefaultGroup();

    public function addMessage($message, $type);

    public function addMessages(array $messages, $type);

    public function addErrorMessage($message);

    public function addWarningMessage($message);

    public function addNoticeMessage($message);

    public function addSuccessMessage($message);

    public function addComplexErrorMessage($identifier, array $data = []);

    public function createMessage(string $type, array $messages, $identifier = null);
}
