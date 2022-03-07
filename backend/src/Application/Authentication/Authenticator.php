<?php

namespace Procesio\Application\Authentication;

use Procesio\Application\Authentication\Exception\AuthenticationException;
use Procesio\Application\Settings\SettingsInterface;
use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\User\User;
use Procesio\Domain\User\UserFacade;
use DateTime;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Authenticator
{
    private string $key;

    private string $algorithm;

    public function __construct(
        private SettingsInterface $settings,
        private UserFacade $userFacade
    ) {
        $this->key = (string)$this->settings->get('jwt_secret');
        $this->algorithm = (string)$this->settings->get('jwt_algorithm');
    }

    /**
     * @throws AuthenticationException
     */
    public function authenticateUser(string $username, string $requestPassword): string {
        try {
            $user = $this->userFacade->getUserByEmail($username);
        } catch (DomainObjectNotFoundException) {
            throw new AuthenticationException();
        }

        $userPassword = $user->getPassword();

        if (!$this->passwordsMatch($userPassword, $requestPassword)) {
            throw new AuthenticationException();
        }

        $payload = $this->generateJwtPayloadForUser($user);
        return $this->generateToken($payload);
    }

    public function verifyToken(string $jwt): array {
        return (array)JWT::decode($jwt, new Key($this->key, $this->algorithm));
    }

    private function generateToken(array $payload): string {
        return JWT::encode($payload, $this->key, $this->algorithm);
    }

    private function generateJwtPayloadForUser(User $user): array {
        return [
            'uid' => $user->getUuid(),
            'username' => $user->getEmail(),
            'exp' => (new DateTime())->modify('+ 1 hour')->getTimestamp()
        ];
    }

    private function passwordsMatch(string $userPassword, string $requestPassword): bool
    {
        return $userPassword === $requestPassword;
    }
}
