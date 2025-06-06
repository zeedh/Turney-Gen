<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Xoco70\LaravelTournaments\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $names = [
            'Junior',
            'Junior Team',
            'Men Single',
            'Men Team',
            'Ladies Single',
            'Ladies Team',
            'Master',
        ];

        $gender = ['M', 'F', 'X'];

        $ageMin = $this->faker->numberBetween(5, 50);
        $ageMax = $this->faker->numberBetween($ageMin + 1, 90);

        $gradeMin = $this->faker->numberBetween(1, 10);
        $gradeMax = $this->faker->numberBetween($gradeMin, 16);

        return [
            'name'          => $this->faker->randomElement($names),
            'gender'        => $this->faker->randomElement($gender),
            'isTeam'        => $this->faker->boolean(),
            'ageCategory'   => $this->faker->numberBetween(0, 5),
            'ageMin'        => $ageMin,
            'ageMax'        => $ageMax,
            'gradeCategory' => $this->faker->numberBetween(0, 5),
            'gradeMin'      => $gradeMin,
            'gradeMax'      => $gradeMax,
        ];
    }
}
