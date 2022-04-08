<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * @throws \Exception
     */
    public function configure()
    {
        return $this->afterCreating(static function (User $user) {
            $user->assignRole(rand(0, 1) ? "driver" : "customer");
        });
    }

    public function definition(): array
    {
        return [
            'full_name' => $this->faker->firstName(),
            'email' => $this->faker->email(),
            'phone' => '998' . $this->faker->numberBetween('100000000', '999999999'),
            'password' => bcrypt(12345678),
            'is_active' => $this->faker->boolean(),
            'phone_confirmed' => $this->faker->boolean(),
            'phone_confirmed_at' => Carbon::now(),
            'author_id' => User::query()->inRandomOrder()->first()?->id,
        ];
    }
}
