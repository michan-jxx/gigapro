<?php

use App\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase{

    /** @test */
    public function test_return_full_name(){

        $user = new User;

        $user->firstName = 'John';
        $user->lastName =  'Doe';

        $result = $user->getFullName();

        $this->assertSame('John Doe', $result);

  }

    /** @test */
    public function return_first_name_charactor_count(){

        $user = new User;

        $user->firstName = 'John';
        $user->lastName =  'Doe';

        $result = $user->getFirstNameCount();

        $this->assertEquals(4, $result);

  }
}
