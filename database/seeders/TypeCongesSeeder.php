<?php

namespace Database\Seeders;

use App\Models\Entreprise;
use App\Models\TypeConge;
use Illuminate\Database\Seeder;

class TypeCongesSeeder extends Seeder
{
    public function run(): void
    {
        $entreprises = Entreprise::all();
        $defaultTypes = TypeConge::getDefaultTypes();

        foreach ($entreprises as $entreprise) {
            foreach ($defaultTypes as $type) {
                TypeConge::firstOrCreate(
                    [
                        'entreprise_id' => $entreprise->id,
                        'code' => $type['code'],
                    ],
                    array_merge($type, [
                        'entreprise_id' => $entreprise->id,
                    ])
                );
            }
        }
    }
}
