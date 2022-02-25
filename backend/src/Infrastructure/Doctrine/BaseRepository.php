<?php

namespace Procesio\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;
use Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException;
use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Package\Package;
use Procesio\Domain\Process\Process;
use Procesio\Domain\Project\Project;
use Procesio\Domain\Subprocess\Subprocess;
use Procesio\Domain\User\User;
use Procesio\Domain\Workspace\Workspace;

abstract class BaseRepository
{
    protected EntityRepository $entityRepository;

    public function __construct(
        protected EntityManager $entityManager
    )
    {
        $this->entityRepository = $entityManager->getRepository($this->getDomainClass());
    }

    /**
     * @return class-string
     */
    abstract protected function getDomainClass(): string;

    /**
     * @return null|User|Workspace|Package|Project|Process|Subprocess
     */
    protected function findByUuid(string $uuid): ?object
    {
        return $this->entityRepository->find($uuid);
    }

    /**
     * @return User|Workspace|Package|Project|Process|Subprocess
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    protected function getByUuid(string $uuid): object
    {
        $object = $this->findByUuid($uuid);

        if ($object === null) {
            throw DomainObjectNotFoundException::createFromDomainObjectClass($this->getDomainClass());
        }

        return $object;
    }

    /**
     * @param string[] $criteria
     * @return User[]
     */
    protected function findBy(array $criteria): array
    {
        return $this->entityRepository->findBy($criteria);
    }

    /**
     * @param string[] $criteria
     * @return User[]
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    protected function getBy(array $criteria): array
    {
        $objects = $this->findBy($criteria);

        if (count($objects) === 0) {
            throw DomainObjectNotFoundException::createFromDomainObjectClass($this->getDomainClass());
        }

        return $objects;
    }

    /**
     * @return User|Package|Workspace|Project|Process|Subprocess
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    protected function getById(string $uuid): object
    {
        $object = $this->findByUuid($uuid);

        if ($object === null) {
            throw DomainObjectNotFoundException::createFromDomainObjectClass($this->getDomainClass());
        }

        return $object;
    }

    /**
     * @return User|Package|Workspace|Project|Process|Subprocess
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    protected function persist(object $object): object
    {
        try {
            $this->entityManager->persist($object);
            $this->entityManager->flush();
            return $object;
        } catch (ORMException) {
            throw CouldNotPersistDomainObjectException::createFromDomainObjectClass($this->getDomainClass());
        }
    }

    /**
     * @return User|Workspace|Project|Package|Process|Subprocess
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    /*protected function merge(object $object): object
    {
        try {

            $this->entityManager->persist($object);
            $this->entityManager->flush();
            return $object;
        } catch (ORMException) {
            throw CouldNotPersistDomainObjectException::createFromDomainObjectClass($this->getDomainClass());
        }
    }*/
}
