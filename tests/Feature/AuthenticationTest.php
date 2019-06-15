<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthenticationTest extends TestCase
{
	use DatabaseMigrations;
   
		public function setUp():void
		{
			parent::setUp();

				$user = new User([
					'email'    => 'test@email.com',
					'password' => '123456',
					'address' =>'Accra, Ring Road',
					'phone_number' =>'08754678234',
					'name' => 'john doe',
			]);

			$user->save();
		}

		public function it_will_register_a_user()
		{
			$response = $this->post('/api/v1/register', [
					'email'    => 'test2@email.com',
					'password' => '123456',
					'address' =>'Tema, com7',
					'phone_number' =>'0748845954003',
					'name' => 'jane Smith',
			]);

			$response->assertJsonStructure([ 
						'access_token',
            'token_type',
            'expires_in'
        ]);
		}

		public function it_will_log_a_user_in()
		{
			$response = $this->post('/api/v1/login', [
				'email'    => 'test2@email.com',
				'password' => '123456',
			
			]);

			$this->response->assertJsonStructure([
				'access_token',
				'token_type',
				'expires_in'
			]);
		}

		 /** @test */
		 public function it_will_not_log_an_invalid_user_in()
		 {
			$response = $this->post('api/v1/login', [
					'email'    => 'test@email.com',
					'password' => 'notlegitpassword'
			]);

			$response->assertJsonStructure([
					'error',
				 ]);
		 }
}
