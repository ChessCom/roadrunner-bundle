<?php
declare(strict_types=1);

namespace Baldinof\RoadRunnerBundle\Worker;

use Baldinof\RoadRunnerBundle\Event\WorkerStartEvent;
use Baldinof\RoadRunnerBundle\Event\WorkerStopEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Temporal\Worker\WorkerFactoryInterface;

/**
 * @internal
 */
class TemporalWorker implements WorkerInterface
{
    private TemporalDependencies $dependencies;
    private WorkerFactoryInterface $workerFactory;
    private iterable $workflows;
    private iterable $activities;

    public function __construct(
        KernelInterface $kernel,
        LoggerInterface $logger,
        WorkerFactoryInterface $workerFactory,
        iterable $workflows,
        iterable $activities
    )
    {
        $this->workerFactory = $workerFactory;

        /** @var TemporalDependencies $dependencies */
        $dependencies = $kernel->getContainer()->get(TemporalDependencies::class);
        $this->dependencies = $dependencies;

        $this->workflows = $workflows;
        $this->activities = $activities;
    }

    public function start(): void
    {
        $this->dependencies->getEventDispatcher()->dispatch(new WorkerStartEvent());

        $worker = $this->workerFactory->newWorker();

        foreach ($this->workflows as $workflow) {
            $worker->registerWorkflowTypes(get_class($workflow));
        }

        foreach ($this->activities as $activity) {
            $worker->registerActivityImplementations($activity);
        }

        $this->workerFactory->run();

        $this->dependencies->getEventDispatcher()->dispatch(new WorkerStopEvent());
    }
}
