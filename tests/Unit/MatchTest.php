<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Http\Controllers\MatchController;

class MatchTest extends TestCase
{
    /**
     * A basic test for the isWinner function.
     *
     * @return void
     */
    public function testIsWinner()
    {
        $matchController = new MatchController;
        $this->assertTrue($matchController->isWinner([
                                                      1,1,1,
                                                      0,0,0,
                                                      0,0,0,
                                                      ]));

        $this->assertTrue($matchController->isWinner([
                                                      0,1,1,
                                                      2,2,2,
                                                      0,2,2,
                                                      ]));

        $this->assertTrue($matchController->isWinner([
                                                        1,1,2,
                                                        0,1,0,
                                                        0,2,1,
                                                        ]));
        
        $this->assertTrue($matchController->isWinner([
                                                        1,1,2,
                                                        0,2,0,
                                                        2,2,1,
                                                        ]));
        
        $this->assertFalse($matchController->isWinner([
                                                        1,1,2,
                                                        0,1,0,
                                                        0,2,0,
                                                        ]));
    }

    public function testApiRequests(){
        $response = $this->get('api/match');
        $response->assertStatus(200);
    }
}
