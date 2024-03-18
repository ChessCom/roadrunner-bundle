<?php

declare(strict_types=1);

namespace Baldinof\RoadRunnerBundle\Worker;

use Baldinof\RoadRunnerBundle\Http\MiddlewareStack;
use Baldinof\RoadRunnerBundle\Reboot\KernelRebootStrategyInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * A simple container class holding services needed by the Temporal Worker.
 *
 * It's used to ease worker dependencies retrieval when the kernel
 * has been rebooted.
 *
 * @internal
 */
final class TemporalDependencies
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }
}
