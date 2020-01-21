<?php

namespace Tests\Feature;

use App\Car;
use App\User;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_list_of_cars_can_be_fetched_for_the_authenticated_user()
    {
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $car = factory(Car::class)->create(['user_id' => $user->id]);
        $anotherCar = factory(Car::class)->create(['user_id' => $anotherUser->id]);

        $response = $this->get('/api/cars?api_token=' . $user->api_token);

        $response->assertJsonCount(1)
            ->assertJson([
                'data' => [
                    [
                        "data" => [
                            'car_id' => $car->id
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function an_unauthenticated_user_should_be_redirected_to_login()
    {
        $response = $this->post('/api/cars',
            array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Car::all());
    }

    /** @test */
    public function an_authenticated_user_can_add_a_car()
    {
        $response = $this->post('/api/cars', $this->data());

        $car = Car::first();

        $this->assertEquals('Lambourghini Capri', $car->name);
        $this->assertEquals('Navy Blue', $car->colour);
        $this->assertEquals('13/02/1980', $car->birthday->format('m/d/Y'));
        $this->assertEquals($this->testUser->id, $car->user_id);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'car_id' => $car->id,
            ],
            'links' => [
                'self' => $car->path(),
            ]
        ]);
    }

    /** @test */
    public function fields_are_required()
    {
        collect(['name', 'colour', 'birthday', 'user_id'])
            ->each(function ($field) {
                $response = $this->post('/api/cars',
                    array_merge($this->data(), [$field => '']));

                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Car::all());
            });
    }

    /** @test */
    // public function photoUrl__must_be_a_valid_email()
    // {
    //     $response = $this->post('/api/cars',
    //         array_merge($this->data(), ['email' => 'NOT AN EMAIL']));

    //     $response->assertSessionHasErrors('email');
    //     $this->assertCount(0, Car::all());
    // }

    /** @test */
    public function birthdays_are_properly_stored()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/cars',
            array_merge($this->data()));

        $this->assertCount(1, Car::all());
        $this->assertInstanceOf(Carbon::class, Car::first()->birthday);
        $this->assertEquals('13-02-1980', Car::first()->birthday->format('d-m-Y'));
    }

    /** @test */
    public function a_car_can_be_retrieved()
    {
        $car = factory(Car::class)->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/cars/' . $car->id . '?api_token=' . $this->user->api_token);

        $response->assertJson([
            'data' => [
                'car_id' => $car->id,
                'name' => $car->name,
                'colour' => $car->colour,
                'birthday' => $car->birthday->format('d/m/Y'),
                'user_id' => $car->user_id,
                'last_updated' => $car->updated_at->diffForHumans(),
            ]
        ]);
    }

    /** @test */
    public function only_the_users_cars_can_be_retrieved()
    {
        $car = factory(Car::class)->create(['user_id' => $this->user->id]);

        $anotherUser = factory(User::class)->create();

        $response = $this->get('/api/cars/' . $car->id . '?api_token=' . $anotherUser->api_token);

        $response->assertStatus(403);
    }

    /** @test */
    public function a_car_can_be_patched()
    {
        $car = factory(Car::class)->create(['user_id' => $this->user->id]);

        $response = $this->patch('/api/cars/' . $car->id, $this->data());

        $car = $car->fresh();

        $this->assertEquals('Lambourghini Capri', $car->name);
        $this->assertEquals('Navy Blue', $car->colour);
        $this->assertEquals('13/02/1980', $car->birthday->format('d/m/Y'));
        $this->assertEquals('John Smith', $car->user_id);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'car_id' => $car->id,
            ],
            'links' => [
                'self' => $car->path(),
            ]
        ]);
    }

    /** @test */
    public function only_the_owner_of_the_car_can_patch_the_car()
    {
        $car = factory(Car::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->patch('/api/cars/' . $car->id,
            array_merge($this->data(), ['api_token' => $anotherUser->api_token]));

        $response->assertStatus(403);
    }

    /** @test */
    public function a_car_can_be_deleted()
    {
        $car = factory(Car::class)->create(['user_id' => $this->user->id]);

        $response = $this->delete('/api/cars/' . $car->id,
            ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Car::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function only_the_owner_can_delete_the_car()
    {
        $car = factory(Car::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->delete('/api/cars/' . $car->id,
            ['api_token' => $this->user->api_token]);

        $response->assertStatus(403);
    }

    private function data()
    {
        $this->testUser = factory(User::class)->create();
        return [
            'name' => 'Lambourghini Capri',
            'colour' => 'Navy Blue',
            'birthday' => '13/02/1980',
            'user_id' => $this->testUser->id,
            'api_token' => $this->user->api_token,
        ];
    }
}
