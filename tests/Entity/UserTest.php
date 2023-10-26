<?php

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testValidEmail(){
        $user = new User();
        $user->setEmail("ssouhila5@gmail.com");
        $this->assertEquals("ssouhila5@gmail.com", $user->getEmail());
    }
    public function testInvalideEmail(){
        $user = new User();
        $this->expectException(\InvalidArgumentException::class);
        $user->setEmail('');
    }

}