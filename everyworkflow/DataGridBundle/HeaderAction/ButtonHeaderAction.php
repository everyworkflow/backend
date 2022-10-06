<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\HeaderAction;

use EveryWorkflow\DataGridBundle\Model\Action;

class ButtonHeaderAction extends Action implements ButtonHeaderActionInterface
{
    protected string $actionType = 'button_header_action';
}
