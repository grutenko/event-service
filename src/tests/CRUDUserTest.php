<?php

use App\Event;
use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Faker\Factory as Faker;

class CRUDUserTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetUsers()
    {
        $this->json('GET', '/users', ['event_id' => '1'])
             ->seeStatusCode(200)
             ->seeJsonStructure(['*' => [
                'first_name',
                'last_name',
                'email'
             ]]);
        $this->json('GET', '/users', [])
             ->seeStatusCode(422)
             ->seeJson(['error' => 'PARAMS_ERROR']);
    }

    public function testAddUsers()
    {
        $faker = Faker::create();
        $this->json('POST', '/users', [
            'first_name'    => $faker->firstName,
            'last_name'     => $faker->lastName,
            'email'         => $faker->email
        ])
        ->seeStatusCode(200)
        ->seeJson(['success' => true]);

        $this->json('POST', '/users', [])
             ->seeStatusCode(422)
             ->seeJson(['error' => 'PARAMS_ERROR']);
    }

    public function testLinkToEvent()
    {
        $faker = Faker::create();
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create();

        $this->json('POST', '/users/1/events', ['event_id' => 1])
             ->seeStatusCode(200)
             ->seeJson(['success' => true]);
    }

    public function testUnlinkEvent()
    {
        $faker = Faker::create();
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create();
        $this->json('DELETE', '/users/1/events', ['event_id' => 1])
             ->seeStatusCode(200)
             ->seeJson(['success' => true]);
    }
}