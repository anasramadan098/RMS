<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-30 days', 'now');
        $checkIn = Carbon::parse($date)->setTime(
            $this->faker->numberBetween(7, 9), // 7-9 AM
            $this->faker->numberBetween(0, 59),
            0
        );
        
        $checkOut = $checkIn->copy()->addHours(
            $this->faker->numberBetween(7, 10) // 7-10 hours later
        )->addMinutes(
            $this->faker->numberBetween(0, 59)
        );

        $totalHours = $checkOut->diffInMinutes($checkIn) / 60;

        return [
            'employee_id' => User::factory(),
            'date' => $date->format('Y-m-d'),
            'check_in' => $checkIn->format('H:i:s'),
            'check_out' => $checkOut->format('H:i:s'),
            'total_hours' => round($totalHours, 2),
            'notes' => $this->faker->optional(0.2)->sentence(),
        ];
    }

    /**
     * Create attendance with only check-in (still working).
     */
    public function checkedInOnly(): static
    {
        return $this->state(fn (array $attributes) => [
            'check_out' => null,
            'total_hours' => null,
        ]);
    }

    /**
     * Create attendance for today.
     */
    public function today(): static
    {
        $checkIn = Carbon::today()->setTime(
            $this->faker->numberBetween(7, 9),
            $this->faker->numberBetween(0, 59),
            0
        );

        return $this->state(fn (array $attributes) => [
            'date' => Carbon::today()->format('Y-m-d'),
            'check_in' => $checkIn->format('H:i:s'),
        ]);
    }

    /**
     * Create attendance for a specific date.
     */
    public function forDate(Carbon $date): static
    {
        $checkIn = $date->copy()->setTime(
            $this->faker->numberBetween(7, 9),
            $this->faker->numberBetween(0, 59),
            0
        );
        
        $checkOut = $checkIn->copy()->addHours(
            $this->faker->numberBetween(7, 10)
        )->addMinutes(
            $this->faker->numberBetween(0, 59)
        );

        $totalHours = $checkOut->diffInMinutes($checkIn) / 60;

        return $this->state(fn (array $attributes) => [
            'date' => $date->format('Y-m-d'),
            'check_in' => $checkIn->format('H:i:s'),
            'check_out' => $checkOut->format('H:i:s'),
            'total_hours' => round($totalHours, 2),
        ]);
    }

    /**
     * Create overtime attendance (more than 8 hours).
     */
    public function overtime(): static
    {
        $date = $this->faker->dateTimeBetween('-30 days', 'now');
        $checkIn = Carbon::parse($date)->setTime(8, 0, 0);
        $checkOut = $checkIn->copy()->addHours(
            $this->faker->numberBetween(9, 12) // 9-12 hours (overtime)
        );

        $totalHours = $checkOut->diffInMinutes($checkIn) / 60;

        return $this->state(fn (array $attributes) => [
            'date' => $date->format('Y-m-d'),
            'check_in' => $checkIn->format('H:i:s'),
            'check_out' => $checkOut->format('H:i:s'),
            'total_hours' => round($totalHours, 2),
            'notes' => 'ساعات إضافية',
        ]);
    }

    /**
     * Create short day attendance (less than normal hours).
     */
    public function shortDay(): static
    {
        $date = $this->faker->dateTimeBetween('-30 days', 'now');
        $checkIn = Carbon::parse($date)->setTime(8, 0, 0);
        $checkOut = $checkIn->copy()->addHours(
            $this->faker->numberBetween(4, 6) // 4-6 hours (short day)
        );

        $totalHours = $checkOut->diffInMinutes($checkIn) / 60;

        return $this->state(fn (array $attributes) => [
            'date' => $date->format('Y-m-d'),
            'check_in' => $checkIn->format('H:i:s'),
            'check_out' => $checkOut->format('H:i:s'),
            'total_hours' => round($totalHours, 2),
            'notes' => 'يوم قصير',
        ]);
    }
}
