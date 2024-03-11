<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Models
use App\Models\Project;
use App\Models\Technology;



class ProjectTechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        
        /* foreach ($projects as $project) {
            
            $randomProject = Project::inRandomOrder()->first();
            $project->technologies()->attach($randomProject->id);
        } */
        foreach ($projects as $project) {
            $technologies = Technology::inRandomOrder()->get();
            
            $counter = 0;
            $maxTechnologies = rand(0, 3);
            foreach ($technologies as $technology) {
                if ($counter < $maxTechnologies) {
                    $project->technologies()->attach($technology->id);
                    $counter++;
                }
                else {
                    break;
                }
            }
        }
    }
}
