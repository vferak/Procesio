<?php

namespace Procesio\Domain\Workspace;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use Procesio\Domain\Package\Package;
use Procesio\Domain\User\User;
use Procesio\Domain\UuidDomainObjectTrait;
use Procesio\Domain\Workspace\Exceptions\CouldNotAddUserException;
use Procesio\Domain\Workspace\Exceptions\CouldNotDeleteWorkspaceException;
use Procesio\Infrastructure\Doctrine\Repositories\PackageRepository;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectRepository;
use Procesio\Infrastructure\Doctrine\Repositories\WorkspaceRepository;

/**
 * @Entity
 * @Table(name="workspace")
 */
class Workspace implements JsonSerializable
{
    use UuidDomainObjectTrait;

    /** @Column(type="string", name="name") */
    private string $name;

    /** @Column(type="string", name="description") */
    private string $description;

    /**
     * @var ArrayCollection|User[]
     * @ManyToMany(targetEntity="Procesio\Domain\User\User", mappedBy="workspaces")
     */
    private mixed $users;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\User\User")
     * @JoinColumn(name="user_uuid", referencedColumnName="uuid", nullable = true)
     */
    private ?User $user;

    /**
     * @var ArrayCollection|Package[]
     * @OneToMany(targetEntity="Procesio\Domain\Package\Package", mappedBy="workspace")
     */
    private mixed $packages;
/*
    /**
     * Many Users have Many Groups.
     * @var ArrayCollection|Process[]
     * @ManyToMany(targetEntity="Procesio\Domain\Process\Process", inversedBy="workspaces")
     * @JoinTable(name="workspace_process",
     *      joinColumns={@JoinColumn(name="workspace_uuid", referencedColumnName="uuid")},
     *      inverseJoinColumns={@JoinColumn(name="process_uuid", referencedColumnName="uuid")}
     *      )
     */
   // private mixed $processes;

    public function __construct(WorkspaceData $workspaceData)
    {
        $this->generateAndSetUuid();

        $this->name = $workspaceData->getName();
        $this->description = $workspaceData->getDescription();
        $this->users = new ArrayCollection();

        if ($workspaceData->getUser() !== null) {
            $this->user = $workspaceData->getUser();
        }

        $this->edit($workspaceData);
    }

    public function edit(WorkspaceData $workspaceData): void
    {
        $this->name = $workspaceData->getName();
        $this->description = $workspaceData->getDescription();
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'user' => $this->getUser(),
            'users' => $this->getUsers()
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users->toArray();
    }


    public function delete(
        WorkspaceRepository $workspaceRepository,
        PackageRepository $packageRepository,
        ProjectRepository $projectRepository
    ): void {
        $packages = $packageRepository->findAllPackagesByWorkspaces($this);
        if ($packages !== null) {
            throw CouldNotDeleteWorkspaceException::createForPackages($packages);
        }

        $projects = $projectRepository->findAllProjectsByWorkspaces($this);
        if ($projects !== null) {
            throw CouldNotDeleteWorkspaceException::createForProjects($projects);
        }

        if ($this->getUser() !== null) {
            throw CouldNotDeleteWorkspaceException::createForDefaultUser();
        }

        $workspaceRepository->deleteWorkspace($this);
    }

    public function addUserToWorkspace(User $user): self
    {
        $users = $this->getUsers();

        foreach ($users as $us) {
            if ($us->getUuid() === $user->getUuid()) {
                throw CouldNotAddUserException::createForDuplicateUser($us);
            }
        }

        $this->addUser($user);
        $user->addWorkspace($this);

        return $this;
    }

    public function addUser(User $user): self
    {
        $this->users->add($user);
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return Package[]
     */
    public function getPackages(): array
    {
        return $this->packages->toArray();
    }

    public function removeUserFromWorkspace(User $user): self
    {
        if (!$this->users->contains($user)) {
            return $this;
        }

        $this->users->removeElement($user);
        $user->removeWorkspaceFromUser($this);

        return $this;
    }
}
