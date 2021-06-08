<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Announcement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6,true),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(200,2000), 
            'price_type' => 1,
            'event_id' => 1,
            'excerpt' => $this->faker->sentence(3,true),
            'category_id' => 2,
            'images' => $this->faker->imageUrl($width = 200, $height = 200),
            'parent' => null,
            'posted_by' => $this->faker->randomDigit(3,true),
            'advertiser_type' => 1,
            'city_id' => $this->faker->randomDigit(12,true),
            'website' => $this->faker->url,
            'email' => $this->faker->email,
            'telephone' => $this->faker->phoneNumber,
            'postal_code' => null,
            'publication_status' => 1,
            'owner' => $this->faker->sentence(3,true),
            'published_at' => $this->faker->date,
            'dates' => null,
            'validated' => 1,
            'validated_by' => 1,
            'validated_at' => $this->faker->date,
            'rejection_reasons' => null,
            'views' => $this->faker->numberBetween(1,110),
            'clicks' => $this->faker->numberBetween(3,300),
            'spotlight' => null,
            'region_id' => $this->faker->numberBetween(1,17),
            'created_at' => $this->faker->date,
            'updated_at' => $this->faker->date,
            'purchased' => null,
            'lock_publication' => $this->faker->numberBetween(0,1),
            'created_by' => $this->faker->numberBetween(1,10),
            'updated_by' => $this->faker->numberBetween(1,10),
        ];
    }
}
