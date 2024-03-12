<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Project;
use App\Models\Type;

// Helpers
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            Project::truncate();
        });
        for ($i = 0; $i < 10; $i++) {
            $title = fake()->sentence();
            $slug = Str::slug($title);
            $randomType = Type::inRandomOrder()->first();
            /* $randomNumber = random_int(1, 300);
            $randomImage = 'https://picsum.photos/id/'.$randomNumber.'/200/300'; */
            $project = Project::create([
                'title' => $title,
                'slug' => $slug,
                'content' => fake()->paragraph(),
                'type_id' => $randomType->id,
                /* 'cover_img' => $randomImage */

            ]);
        }
    }
}
