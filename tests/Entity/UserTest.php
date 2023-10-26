<?php

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testValidEmail()
    {
        $user = new User();
        $user->setEmail("mpol@gmail.com");
        $this->assertEquals("mpol@gmail.com", $user->getEmail());
    }
    public function testInvalideEmail()
    {

        $this->expectException(\InvalidArgumentException::class);
        $user = new User();
        $this->expectExceptionMessage("message d'exception attendu");
        $user->setEmail('');
    }
}
