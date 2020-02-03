<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RacesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cars_with_races_in_the_current_month_can_be_fetched()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $raceCar = factory(Car::class)->create([
            'user_id' => $user->id,
            'race' => now()->subYear(),
        ]);
        $noRaceCar = factory(Car::class)->create([
            'user_id' => $user->id,
            'race' => now()->subMonth(),
        ]);

        $this->get('/api/races?api_token=' . $user->api_token)
            ->assertJsonCount(1)
            ->assertJson([
                'data' => [
                    [
                        "data" => [
                            'car_id' => $raceCar->id
                        ]
                    ]
                ]
            ]);
    }
}
