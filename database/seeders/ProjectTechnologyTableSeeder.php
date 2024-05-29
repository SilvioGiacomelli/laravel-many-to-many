<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Technology;

class ProjectTechnologyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 0; $i < 100; $i++) {

            $project = Project::inRandomOrder()->first();

            $technology_id = Technology::inRandomOrder()->first()->id;

            $project->technologies()->attach($technology_id); //qui non metto sync ma attach, perchè voglio aggiungere tecnologie in modo casuale, sync invece cancella le tecnologie e ne aggiunge di nuove
        }
    }
}
