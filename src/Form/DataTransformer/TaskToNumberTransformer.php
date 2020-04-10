<?php

namespace App\Form\DataTransformer;

use App\Entity\Task;
use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\ORM\EntityManagerInterface;

class TaskToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (taskList) to a string (number).
     *
     * @param  Task|null $taskList
     * @return string
     */
    public function transform($task)
    {
        if (null === $task) {
            return '';
        }

        return $task->getId();
    }

    /**
     * Transforms a string (number) to an object (taskList).
     *
     * @param  string $taskListNumber
     * @return Task|null
     * @throws TransformationFailedException if object (taskList) is not found.
     */
    public function reverseTransform($taskNumber)
    {
        // no issue number? It's optional, so that's ok
        if (!$taskNumber) {
            return;
        }

        $task = $this->entityManager
            ->getRepository(Task::class)
            // query for the issue with this id
            ->find($taskNumber)
        ;

        if (null === $task) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An taskList with number "%s" does not exist!',
                $taskNumber
            ));
        }

        return $task;
    }
}