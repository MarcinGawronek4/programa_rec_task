<?php

namespace Tests\Domain\User;

use App\Domain\User\User;
use App\Domain\User\UserFactory;
use PHPUnit\Framework\TestCase;

class UserFactoryTest extends TestCase
{
    private UserFactory $userFactory;

    protected function setUp(): void
    {
        $this->userFactory = new UserFactory();
    }

    public function testFactoryCreatesValidUserInstance(): void
    {
        $user = $this->userFactory->create("testuser", "testpassword", "testuser", "test@test.pl");

        $this->assertInstanceOf(User::class, $user, "UserFactory should return an instance of User");
    }

    public function testFactorySetsCorrectUsername(): void
    {
        $user = $this->userFactory->create("testuser", "testpassword", "testuser", "test@test.pl");

        $this->assertEquals("testuser", $user->getUsername(), "UserFactory should set the username correctly");
    }

    public function testFactorySetsCorrectPassword(): void
    {
        $user = $this->userFactory->create("testuser", "testpassword", "testuser", "test@test.pl");

        $this->assertEquals("testpassword", $user->getPassword(), "UserFactory should set the password correctly");
    }

    public function testFactoryAssignsDefaultRole(): void
    {
        $user = $this->userFactory->create("testuser", "testpassword", "testuser", "test@test.pl");

        $this->assertContains("ROLE_USER", $user->getRoles(), "UserFactory should assign ROLE_USER by default");
    }

    public function testFactoryAssignsCustomRoles(): void
    {
        $user = $this->userFactory->create("admin", "adminpass", "testuser", "test@test.pl", ["ROLE_ADMIN"]);

        $this->assertContains("ROLE_ADMIN", $user->getRoles(), "UserFactory should allow assigning custom roles");
    }

    public function testFactoryThrowsErrorOnEmptyUsername(): void
    {
        $this->expectException(\TypeError::class);

        $this->userFactory->create(null, "testpassword", "testuser", "test@test.pl");
    }
}