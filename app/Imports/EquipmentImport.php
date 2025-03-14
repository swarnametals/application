<?php
namespace App\Imports;

use App\Models\Equipment;
use App\Models\EquipmentInsurance;
use App\Models\EquipmentTax;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class EquipmentImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $dateFields = [
            'insurance_expiry_date',
            'road_tax_expiry_date',
            'fitness_expiry_date',
            'identity_expiry_date',
            'first_registration_date',
        ];

        foreach ($dateFields as $field) {
            if (isset($row[$field]) && !empty($row[$field])) {
                Log::debug("Raw {$field} value: " . json_encode($row[$field]));
                try {
                    // Parse string date in DD.MM.YYYY format
                    $row[$field] = Carbon::createFromFormat('d.m.Y', $row[$field])->format('Y-m-d');
                } catch (\Exception $e) {
                    Log::warning("Failed to parse {$field} with value '{$row[$field]}': " . $e->getMessage());
                    $row[$field] = null;
                }
            } else {
                $row[$field] = null;
            }
        }

        $data = [
            'equipment_name' => $row['equipment_name'],
            'registration_number' => $row['registration_number'] . ' ZM',
            'ownership' => $row['ownership'],
            'type' => $row['type'],
            'engine_number' => $row['engine_number'],
            'value' => 0,
            'chassis_number' => $row['chassis_number'], // Fixed typo from previous
            'date_purchased' => $row['first_registration_date'],
        ];

        $equipment = Equipment::updateOrCreate(
            ['registration_number' => $data['registration_number']],
            $data
        );

        EquipmentInsurance::updateOrCreate(
            ['equipment_id' => $equipment->id],
            [
                'insurance_company' => $row['insurance_company'],
                'phone_number' => '0954176379',
                'address' => 'Suite No. 210/211 Mukuba Pension House Kitwe, Zambia',
                'premium' => 0,
                'expiry_date' => $row['insurance_expiry_date'],
            ]
        );

        EquipmentTax::updateOrCreate(
            ['equipment_id' => $equipment->id, 'name' => 'ROAD TAX'],
            [
                'cost' => 0,
                'expiry_date' => $row['road_tax_expiry_date'],
            ]
        );

        EquipmentTax::updateOrCreate(
            ['equipment_id' => $equipment->id, 'name' => 'FITNESS TAX'],
            [
                'cost' => 0,
                'expiry_date' => $row['fitness_expiry_date'],
            ]
        );

        EquipmentTax::updateOrCreate(
            ['equipment_id' => $equipment->id, 'name' => 'IDENTITY TAX'],
            [
                'cost' => 0,
                'expiry_date' => $row['identity_expiry_date'],
            ]
        );

        return null;
    }

    public function rules(): array
    {
        return [
            'equipment_name' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'ownership' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'engine_number' => 'required|string|max:255',
            'chassis_number' => 'required|string|max:255',
            'first_registration_date' => 'required|date_format:d.m.Y',
            'insurance_company' => 'required|string|max:255',
            'insurance_expiry_date' => 'required|date_format:d.m.Y',
            'road_tax_expiry_date' => 'required|date_format:d.m.Y',
            'fitness_expiry_date' => 'required|date_format:d.m.Y',
            'identity_expiry_date' => 'required|date_format:d.m.Y',
        ];
    }
}
