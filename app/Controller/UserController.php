<?php

namespace App\Controller;

use App\Model\User;
use Hyperf\HttpServer\Annotation\AutoController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;

/**
 * @AutoController()
 */
class UserController
{
    /**
     * @Inject
     * @var LoggerFactory
     */
    private $loggerFactory;

    private $logger;

    /**
     * @Inject
     * @var HttpResponse
     */
    private $httpResponse;

    public function __construct()
    {
        $this->logger = $this->loggerFactory->get('app', 'default');
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $data = $request->getParsedBody();
            $this->logger->info('Request data: ' . json_encode($data));
            $user = User::create($data);
            $this->logger->info('User created: ' . json_encode($user));
            return $this->jsonResponse($user);
        } catch (\Exception $e) {
            $this->logger->error('Error creating user: ' . $e->getMessage());
            $this->logger->error('Exception Trace: ' . $e->getTraceAsString());
            return $this->jsonResponse(['error' => 'Internal Server Error'], 500);
        }
    }

    public function show(ServerRequestInterface $request, int $id): ResponseInterface
    {
        try {
            $user = User::findOrFail($id);
            return $this->jsonResponse($user);
        } catch (\Exception $e) {
            $this->logger->error('Error fetching user: ' . $e->getMessage());
            return $this->jsonResponse(['error' => 'User not found'], 404);
        }
    }

    public function update(ServerRequestInterface $request, int $id): ResponseInterface
    {
        try {
            $data = $request->getParsedBody();
            $this->logger->info('Request data: ' . json_encode($data));
            $user = User::findOrFail($id);
            $user->update($data);
            return $this->jsonResponse($user);
        } catch (\Exception $e) {
            $this->logger->error('Error updating user: ' . $e->getMessage());
            return $this->jsonResponse(['error' => 'Internal Server Error'], 500);
        }
    }

    public function destroy(ServerRequestInterface $request, int $id): ResponseInterface
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return $this->jsonResponse(['message' => 'User deleted']);
        } catch (\Exception $e) {
            $this->logger->error('Error deleting user: ' . $e->getMessage());
            return $this->jsonResponse(['error' => 'Internal Server Error'], 500);
        }
    }

    private function jsonResponse($data, $statusCode = 200): ResponseInterface
    {
        return $this->httpResponse->json($data)->withStatus($statusCode);
    }
}
