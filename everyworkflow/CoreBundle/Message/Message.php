<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Message;

class Message implements MessageInterface
{
    /**
     * Eg: $message['success']['scope_data_validation'][] = "Data types message".
     */
    private array $message;

    public function getMessages($clear = false): array
    {
        return $this->message;
    }

    /**
     * @return void
     */
    public function getDefaultGroup()
    {
        // TODO: Implement getDefaultGroup() method.
    }

    /**
     * @return void
     */
    public function addMessage($message, $type)
    {
        $this->createMessage($type, $message);
    }

    /**
     * @return void
     */
    public function addMessages(array $messages, $type)
    {
        $this->createMessage($type, $messages);
    }

    /**
     * @return void
     */
    public function addErrorMessage($message)
    {
        $this->createMessage(MessageInterface::TYPE_ERROR, $message);
    }

    /**
     * @return void
     */
    public function addWarningMessage($message)
    {
        $this->createMessage(MessageInterface::TYPE_WARNING, $message);
    }

    /**
     * @return void
     */
    public function addNoticeMessage($message)
    {
        $this->createMessage(MessageInterface::TYPE_NOTICE, $message);
    }

    /**
     * @return void
     */
    public function addSuccessMessage($message)
    {
        $this->createMessage(MessageInterface::TYPE_SUCCESS, $message);
    }

    /**
     * @return void
     */
    public function addComplexErrorMessage($identifier, array $data = [])
    {
        // TODO: Implement addComplexErrorMessage() method.
    }

    /**
     * @param $type
     * @param $messages
     * @param null $identifier
     *
     * @return void
     */
    public function createMessage(string $type, array $messages, $identifier = null)
    {
        if (is_array($messages)) {
            foreach ($messages as $message) {
                $this->message[$type][empty($identifier)
                    ? MessageInterface::DEFAULT_IDENTIFIER
                    : $identifier][] = $message;
            }
        } else {
            $this->message[$type][empty($identifier)
                ? MessageInterface::DEFAULT_IDENTIFIER
                : $identifier][] = $messages;
        }
    }
}
