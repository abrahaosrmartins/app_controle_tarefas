<?php

namespace Database\Seeders;

use App\Models\Tarefa;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class TarefaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return Collection|Model
     */
    public function run()
    {
        return Tarefa::factory()->count(20)->create();
    }
}
