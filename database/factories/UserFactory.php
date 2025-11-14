<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');
        $cities = ['Jakarta Selatan', 'Bandung', 'Surabaya', 'Semarang', 'Yogyakarta', 'Medan', 'Makassar'];
        $domains = ['gmail.com', 'yahoo.com', 'mitraalkes.id', 'sehatq.com'];
        $name = $faker->name();
        $city = $faker->randomElement($cities);

        return [
            'name' => $name,
            'email' => Str::of($name)->slug('.') . '.' . fake()->unique()->numberBetween(1985, 2004) . '@' . $faker->randomElement($domains),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'customer',
            'phone' => '08' . $faker->numerify('1#########'),
            'city' => $city,
            'address' => $faker->streetAddress() . ', ' . $city,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn () => ['role' => 'admin']);
    }

    public function vendor(): static
    {
        return $this->state(fn () => ['role' => 'vendor']);
    }

    public function customer(): static
    {
        return $this->state(fn () => ['role' => 'customer']);
    }
}
