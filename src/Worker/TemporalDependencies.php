<?php

declare(strict_types=1);

namespace Baldinof\RoadRunnerBundle\Worker;

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
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }
}
