<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\User;

use Procesio\Application\Actions\Action;
use Procesio\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param LoggerInterface $logger
     * @param UserRepository $userRepository
     */
    public function __construct(
        LoggerInterface $logger,
        UserRepository $userRepository
    ) {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
    }
}
