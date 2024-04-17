<?php

namespace Database\Seeders;

use App\Models\EventParticipant;
use Database\Factories\EventParticipantFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParticipantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventParticipant::factory(15)->create();
    }
}
