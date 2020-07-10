<?php

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetUsers()
    {
        $this->json('GET', '/users', ['event_id' => '1'])
             ->seeJson([
                'created' => true,
             ]);
    }
}