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
        $this->assertEquals('02/13/1980', $car->race->format('m/d/Y'));
        $this->assertEquals($this->user->id, $car->user_id);
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
        collect(['name', 'colour', 'race', 'user_id', 'value'])
            ->each(function ($field) {
                $response = $this->post('/api/cars',
                    array_merge($this->data(), [$field => '']));

                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Car::all());
            });
    }

    /** @test */
    public function races_are_properly_stored()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/cars',
            array_merge($this->data()));

        $this->assertCount(1, Car::all());
        $this->assertInstanceOf(Carbon::class, Car::first()->race);
        $this->assertEquals('13-02-1980', Car::first()->race->format('d-m-Y'));
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
                'race' => $car->race->format('m/d/Y'),
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
        $this->assertEquals('13/02/1980', $car->race->format('d/m/Y'));
        $this->assertEquals( $this->user->id, $car->user_id);
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
        return [
            'name' => 'Lambourghini Capri',
            'colour' => 'Navy Blue',
            'value' => '10.99',
            'race' => '02/13/1980',
            'user_id' => $this->user->id,
            'api_token' => $this->user->api_token
        ];
    }
}
