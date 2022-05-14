<?php

declare(strict_types=1);

namespace Procesio\Application\Middleware;

use Procesio\Application\Authentication\Authenticator;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpUnauthorizedException;
use UnexpectedValueException;
use InvalidArgumentException;

class AuthMiddleware implements Middleware
{
    public function __construct(
        private Authenticator $authentication
    ) {
    }

    /**
     * {@inheritdoc}
     * @throws HttpUnauthorizedException
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $publicPaths = [
            '/v1/login',
            '/v1/register'
        ];

        if ($request->getMethod() === "OPTIONS" || in_array($request->getUri()->getPath(), $publicPaths)) {
            return $handler->handle($request);
        }

        $bearerString = 'Bearer';

        $authHeader = $request->getHeader("Authorization");
        if (!isset($authHeader[0]) || !str_contains($authHeader[0], $bearerString)) {
            throw new HttpUnauthorizedException($request);
        }

        $jwt = ltrim(trim($authHeader[0], $bearerString));
        if ($jwt) {
            try {
                $jwtData = $this->authentication->verifyToken($jwt);
                $request = $request->withAttribute("userUuid", $jwtData['uid']);
            } catch (InvalidArgumentException |
                UnexpectedValueException |
                SignatureInvalidException |
                BeforeValidException
            ) {
                throw new HttpUnauthorizedException($request);
            } catch (ExpiredException) {
                // TODO Expired redirect
            }
        }

        return $handler->handle($request);
    }
}
