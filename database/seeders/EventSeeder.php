<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Generate a fake image and return its path.
     */
    protected function generateFakeImage(string $directory = 'events'): ?string
    {
        try {
            // Create the directory if it doesn't exist
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            // Create a temporary file with random image content
            $imageUrl = 'https://picsum.photos/800/600?random=' . rand(1, 1000);
            $tempFile = tempnam(sys_get_temp_dir(), 'event_');
            file_put_contents($tempFile, file_get_contents($imageUrl));
            
            // Generate a unique filename
            $filename = $directory . '/' . uniqid() . '.jpg';
            
            // Store the file in the storage
            Storage::disk('public')->put($filename, file_get_contents($tempFile));
            
            // Clean up
            unlink($tempFile);
            
            return $filename;
        } catch (\Exception $e) {
            \Log::error('Failed to generate fake image: ' . $e->getMessage());
            return null;
        }
    }

    public function run(): void
    {
        // Create storage directory if it doesn't exist
        if (!Storage::disk('public')->exists('events')) {
            Storage::disk('public')->makeDirectory('events');
        }

        // Ensure we have some users
        if (User::count() < 5) {
            try {
                // Create an admin user if none exists
                User::firstOrCreate(
                    ['email' => 'admin@example.com'],
                    [
                        'name' => 'Admin User',
                        'password' => bcrypt('password'),
                        'role' => 'admin',
                        'phone' => '+1234567890',
                    ]
                );
                
                // Create some regular users if we don't have enough
                $existingUsers = User::count();
                if ($existingUsers < 5) {
                    User::factory(5 - $existingUsers)->create();
                }
            } catch (\Exception $e) {
                \Log::error('Error creating users: ' . $e->getMessage());
                throw $e;
            }
        }

        // Clear existing events
        \DB::table('events')->delete();

        // Get all users for event creation
        $users = User::all();
        
        // Create 30 events with fake data
        $events = collect();
        $eventCount = 30;

        // Create events with different statuses
        for ($i = 0; $i < $eventCount; $i++) {
            // 70% chance of upcoming, 20% ongoing, 10% completed/cancelled
            $statusRand = rand(1, 10);
            $factory = Event::factory();
            
            if ($statusRand <= 7) {
                $factory = $factory->upcoming();
            } elseif ($statusRand <= 9) {
                $factory = $factory->ongoing();
            } else {
                $startDate = $this->faker->dateTimeBetween('-1 month', '-2 days');
                $endDate = (clone $startDate)->modify('+' . rand(1, 3) . ' hours');
                
                $factory = $factory->state([
                    'status' => $this->faker->randomElement(['completed', 'cancelled']),
                    'start_datetime' => $startDate,
                    'end_datetime' => $endDate,
                ]);
            }
            
            // 10% chance of being a private event
            if ($this->faker->boolean(10)) {
                $factory = $factory->private();
            }

            $event = $factory->create([
                'user_id' => $users->random()->id,
                'image' => $this->faker->boolean(80) ? $this->generateFakeImage('events') : null,
            ]);
            
            $events->push($event);

            // Add some random attendees to the event (1-20 users per event)
            $maxAttendees = min(20, $event->max_participants - 1);
            $attendeeCount = rand(1, $maxAttendees);
            $attendees = $users->where('id', '!=', $event->user_id)
                             ->shuffle()
                             ->take($attendeeCount);
            
            foreach ($attendees as $attendee) {
                // Ensure we have a valid date range for registration
                $startDate = min($event->created_at, $event->start_datetime);
                $endDate = $event->start_datetime;
                
                // If for some reason start is after end, adjust them
                if ($startDate > $endDate) {
                    $temp = $startDate;
                    $startDate = $endDate;
                    $endDate = $temp;
                }
                
                $registrationDate = $this->faker->dateTimeBetween(
                    $startDate,
                    $endDate
                );
                
                $status = $event->status === 'completed' 
                    ? $this->faker->randomElement(['attended', 'no_show']) 
                    : 'registered';
                
                $event->attendees()->attach($attendee->id, [
                    'status' => $status,
                    'registration_date' => $registrationDate,
                    'created_at' => $registrationDate,
                    'updated_at' => $registrationDate,
                ]);
            }

            // Update progress
            if (($i + 1) % 5 === 0) {
                $this->command->info("Created {$event->title} with {$attendeeCount} attendees");
            }
        }

        $this->command->info('\nSuccessfully seeded ' . $events->count() . ' events with random attendees!');
    }
}