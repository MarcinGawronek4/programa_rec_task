<?php

namespace App\Application;

use Overblog\GraphQLBundle\Annotation as GraphQL;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

/**
 * @GraphQL\Provider
 */
class UserGraphQLResolver implements MutationInterface
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @GraphQL\Mutation(name="saveUsers", type="[User]")
     */
    public function saveUsers(): array
    {
        return $this->userService->saveUsers();
    }
}