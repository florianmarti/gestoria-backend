<?php

namespace Database\Seeders;

use App\Models\Procedure;
use App\Models\ProcedureRequirement;
use Illuminate\Database\Seeder;

class ProcedureSeeder extends Seeder
{
    public function run()
    {
        $procedures = [
            [
                'name' => 'Transferencia de vehículo',
                'category' => 'automotor',
                'description' => 'Gestión completa del cambio de titularidad vehicular.',
                'fee' => 15000.00,
                'estimated_days' => 3,
                'requirements' => [
                    ['name' => 'DNI del titular', 'type' => 'file', 'is_required' => true, 'description' => 'Copia del DNI del titular actual.'],
                    ['name' => 'Título del vehículo', 'type' => 'file', 'is_required' => true, 'description' => 'Título de propiedad del vehículo.'],
                    ['name' => 'Número de chasis', 'type' => 'text', 'is_required' => true, 'description' => 'Número de chasis del vehículo.'],
                ],
            ],
            [
                'name' => 'Inscripción inicial (Patentamiento)',
                'category' => 'automotor',
                'description' => 'Registro del primer vehículo.',
                'fee' => 20000.00,
                'estimated_days' => 5,
                'requirements' => [
                    ['name' => 'Factura de compra', 'type' => 'file', 'is_required' => true, 'description' => 'Factura original de compra del vehículo.'],
                    ['name' => 'DNI del propietario', 'type' => 'file', 'is_required' => true, 'description' => 'Copia del DNI del propietario.'],
                ],
            ],
            [
                'name' => 'Libre Deuda',
                'category' => 'impositivo',
                'description' => 'Obtención de certificado de libre deuda.',
                'fee' => 5000.00,
                'estimated_days' => 1,
                'requirements' => [
                    ['name' => 'CUIT/CUIL', 'type' => 'text', 'is_required' => true, 'description' => 'Número de CUIT o CUIL del solicitante.'],
                ],
            ],
        ];

        foreach ($procedures as $procedureData) {
            $requirements = $procedureData['requirements'];
            unset($procedureData['requirements']);

            $procedure = Procedure::create($procedureData);

            foreach ($requirements as $requirement) {
                ProcedureRequirement::create([
                    'procedure_id' => $procedure->id,
                    'name' => $requirement['name'],
                    'type' => $requirement['type'],
                    'is_required' => $requirement['is_required'],
                    'description' => $requirement['description'],
                ]);
            }
        }
    }
}
