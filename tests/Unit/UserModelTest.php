<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Exceptions\UserAccountHasbeenBlockedException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class UserModelTest extends TestCase
{	
	/**
	 * Refresh database
	 */
	use RefreshDatabase;

	private $user;

    protected function setUp(): void
    {
    	parent::setup();

    	$this->user = factory(\App\User::class)->make();
    }

    /** @test */
    public function user_has_full_name_attribute()
    {	
    	$user = \App\User::create([
    		'name' => 'Masud',
    		'lastname' => 'Rana',
    		'email' => 'Masud@gmail.com',
    		'password' => 'secret'
    	]);

    	dd($user);
    	// 
        $this->assertEquals('Masud Rana', $user->fullname);
    }

    /** @test */
    public function user_has_name()
    {	
    	// $users = factory(\App\User::class,1)->make();
    	// foreach ($users as $user) {
    		// dd($users->name);
    	// }
    	
    	// $user = factory(\App\User::class)->make();
    	// $name = $user->name;


        $this->assertNotEmpty($this->user->name);
    }

     /** @test */
    public function check_blocked_user()
    {	
    	//insert user
    	$user = factory(\App\User::class)->make(['email'=>'block@gmail.com']);

    	//auth user
    	$this->actingAs($user);

    	try {
  	 	 	if($user->email == 'block@gmail.com'){
    			throw new UserAccountHasbeenBlockedException("Mairala");
    		}
    	} catch (\Exception $e) {
    	  // var_dump($e);
    	  $exception = true;
    	}
    	$this->assertTrue($exception);
    }
}
