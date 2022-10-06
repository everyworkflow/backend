<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\RowAction;

use EveryWorkflow\DataGridBundle\Model\Action;

class ButtonRowAction extends Action implements ButtonRowActionInterface
{
    protected string $actionType = 'button_row_action';
}
