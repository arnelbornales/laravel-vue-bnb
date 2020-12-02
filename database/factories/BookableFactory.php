<?php

namespace Database\Factories;

use App\Models\Bookable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;



class BookableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookable::class;

    private static $suffix = [
        'Villa',
        'House',
        'Cottage',
        'Luxury Villas',
        'Cheap House',
        'Rooms',
        'Cheap Rooms',
        'Luxury Rooms',
        'Fancy Rooms'
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->city . ' ' . Arr::random(self::$suffix),
            'description' => $this->faker->text(),
            'price' => random_int(15, 250),
            'image' => $this->faker->image('public/storage/images',670,440, null, false),
        ];
    }
}
