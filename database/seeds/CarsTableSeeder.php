<?php

use Faker\Factory;
use App\Models\Car;
use Illuminate\Database\Seeder;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carImageUrls = [
            "015_-_'69_Chevelle_(2nd_Color).jpg",
            "016_-_HW_Formula_Solar.jpg",
            "017_-_Carbonator.jpg",
            "018_-_Chill_Mill.jpg",
            "019_-_2005_Ford_Mustang.jpg",
            "020_-_'18_Copo_Camaro_SS.jpg",
            "021_-Aero_Pod_(2nd_Color).jpg",
            "021_-_Aero_Pod.jpg",
            "022_-_Wheelie_Chair.jpg",
            "025_-_Indy_500_Oval.jpg",
            "0572B057-D920-4F7F-B03D-CCD7A8EDE555.jpg",
            "18_COPO_Camaro_SS_-_2020_Black.JPG.jpg",
            "2020-22B.JPG.jpg",
            "2020NM03_(Large).JPG.jpg",
            "2020_Hot_Wheels_Red_Edition_Indy_500.png",
            "2DCBFBA7-BED1-49D1-B8FA-7C46C107D4D0.jpg",
            "Hot_Wheels_2020_Subaru_Impreza_red.jpg",
            "blue-long.jpg",
            "blue-truck.jpg",
            "blue-yellow.jpg",
            "chevelle.jpg",
            "green-yellow.jpg",
            "grey.jpg",
            "mauve.jpg",
            "motorbike.jpg",
            "multicoloured.jpg",
            "night-shifter.jpg",
            "octane.jpg",
            "orange-honda.jpg",
            "purple.jpeg",
            "silver.jpg",
            "skyline.jpg",
            "snoopy.jpg",
            "toilet.jpg",
            "yellow.jpg",
        ];

        $faker = Factory::create();

        factory(Car::class, 24)->create(['user_id' => 1])->each(
            function ($car) use ($faker, $carImageUrls) {
                $car->photoUrl = $faker->unique()->randomElement($carImageUrls);
                $car->save();
            }
        );
    }
}
