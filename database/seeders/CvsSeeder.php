<?php

namespace Database\Seeders;

use App\Models\Cvs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CvsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cvs::factory()->count(10)->create();
    }
}
