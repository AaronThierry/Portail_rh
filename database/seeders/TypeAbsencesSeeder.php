<?php

namespace Database\Seeders;

use App\Models\Entreprise;
use App\Models\TypeAbsence;
use Illuminate\Database\Seeder;

class TypeAbsencesSeeder extends Seeder
{
    public function run(): void
    {
        $entreprises = Entreprise::all();

        foreach ($entreprises as $entreprise) {
            foreach (TypeAbsence::getDefaultTypes() as $type) {
                TypeAbsence::firstOrCreate(
                    [
                        'entreprise_id' => $entreprise->id,
                        'code' => $type['code'],
                    ],
                    array_merge($type, ['entreprise_id' => $entreprise->id])
                );
            }
        }
    }
}
