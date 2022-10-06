<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\BulkAction;

use EveryWorkflow\DataGridBundle\Model\Action;

class ButtonBulkAction extends Action implements ButtonBulkActionInterface
{
    protected string $actionType = 'button_bulk_action';
}
