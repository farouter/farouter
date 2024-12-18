<?php

namespace Database\Seeders;

use App\Models\Root;
use Illuminate\Database\Seeder;

class RootSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Root::solid('root')->create([
            'title' => 'New website',
        ]);
    }
}
