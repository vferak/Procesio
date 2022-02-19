<?php
declare(strict_types=1);

use Procesio\Application\Handlers\HttpErrorHandler;
use Procesio\Application\Handlers\ShutdownHandler;
use Procesio\Application\ResponseEmitter\ResponseEmitter;
use Procesio\Application\Settings\SettingsInterface;
use Procesio\Bootstrap;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/../vendor/autoload.php';

$bootstrap = new Bootstrap();
$container = $bootstrap->getContainer();
$app = $bootstrap->getAppInstance($container);

/** @var SettingsInterface $settings */
$settings = $container->get(SettingsInterface::class);
$callableResolver = $app->getCallableResolver();

$displayErrorDetails = $settings->get('development');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run App & Emit Response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
