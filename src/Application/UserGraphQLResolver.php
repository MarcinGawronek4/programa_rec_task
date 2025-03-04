<?php

namespace App\Application;

use App\Application\UserService;
use Overblog\GraphQLBundle\Annotation as GraphQL;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

/**
 * @GraphQL\Provider
 */
class UserGraphQLResolver implements QueryInterface
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @GraphQL\Query(
     *     name="users",
     *     type="[User]"
     * )
     */
    public function resolveUsers(): array
    {
        return $this->userService->getUsers();
    }
}