<?php

declare(strict_types=1);

namespace Procesio\Domain\User;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use mysql_xdevapi\Exception;
use Procesio\Application\Authentication\PasswordManager;
use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\User\Exceptions\UserEmailAlreadyRegisteredException;
use Procesio\Domain\UuidDomainObjectTrait;
use Procesio\Domain\Workspace\Workspace;

/**
 * @Entity
 * @Table(name="users")
 */
class User implements JsonSerializable
{
    use UuidDomainObjectTrait;

    /** @Column(type="string", name="email", unique=true) */
    private string $email;

    /** @Column(type="string", name="password") */
    private string $password;

    /** @Column(type="string", name="firstName") */
    private string $firstName;

    /** @Column(type="string", name="lastName") */
    private string $lastName;

    /** @Column(type="datetime", name="registered_at", options={"default": "CURRENT_TIMESTAMP"}) */
    private DateTime $registeredAt;

    /**
     * Many Users have Many Groups.
     * @var ArrayCollection|Workspace[]
     * @ManyToMany(targetEntity="Procesio\Domain\Workspace\Workspace", inversedBy="users")
     * @JoinTable(name="user_workspace",
     *      joinColumns={@JoinColumn(name="user_uuid", referencedColumnName="uuid")},
     *      inverseJoinColumns={@JoinColumn(name="workspace_uuid", referencedColumnName="uuid")}
     *      )
     */
    private mixed $workspaces;

    public function __construct(
        UserData $userData,
        UserRepositoryInterface $userRepository,
        PasswordManager $passwordManager
    ) {
        $passwordManager->validatePassword($userData->getPassword());

        if ($userRepository->findUserByEmail($userData->getEmail()) !== null) {
            throw UserEmailAlreadyRegisteredException::createFromEmail($userData->getEmail());
        }

        $this->registeredAt = new \DateTime();

        $this->generateAndSetUuid();

        $this->workspaces = new ArrayCollection();

        $this->edit($userData, $passwordManager);
    }

    public function edit(UserData $userData, PasswordManager $passwordManager): void
    {
        $this->email = $userData->getEmail();
        $this->firstName = $userData->getFirstName();
        $this->lastName = $userData->getLastName();

        if ($userData->getPassword() !== null) {
            $this->password = $passwordManager->hashPassword($userData->getPassword());
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'username' => $this->getEmail(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName()
        ];
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return Workspace[]
     */
    public function getWorkspaces(): array
    {
        return $this->workspaces->toArray();
    }

    public function addWorkspace(Workspace $workspace): self
    {
        $this->workspaces->add($workspace);
        return $this;
    }

    public function getDefaultWorkspace(): Workspace
    {
        foreach ($this->workspaces as $workspace) {
            if ($workspace->getUser() === $this) {
                return $workspace;
            }
        }

        throw DomainObjectNotFoundException::createFromDomainObjectClass(Workspace::class);
    }

    /**
     * @return DateTime
     */
    public function getRegisteredAt(): DateTime
    {
        return $this->registeredAt;
    }

    public function removeWorkspaceFromUser(Workspace $workspace): User
    {
        if (!$this->workspaces->contains($workspace)) {
            return $this;
        }

        $this->workspaces->removeElement($workspace);
        $workspace->removeUserFromWorkspace($this);

        return $this;
    }
}
