<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lecturer;
use App\Models\StructuralPosition;
use Illuminate\Support\Str;

class NewLecturersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dosen baru yang akan ditambahkan
        $newLecturers = [
            [
                'name' => 'Rina Setyawati, S.Si., M.Pd',
                'position_name' => 'Ketua Program Studi D3 TLM',
                'category' => 'Program Studi',
                'nidn' => '0101018801', // Generated NIDN
                'email' => 'rina.setyawati@kampus.ac.id'
            ],
            [
                'name' => 'Yuri Pradika, S.Si., M.Sc',
                'position_name' => 'Ketua Program Studi D4 TLM',
                'category' => 'Program Studi',
                'nidn' => '0102018902', // Generated NIDN
                'email' => 'yuri.pradika@kampus.ac.id'
            ],
            [
                'name' => 'Ns. Asrifah Suardi, S.Kep., M.M',
                'position_name' => 'Wakil Ketua Bagian Akademik',
                'category' => 'Bagian',
                'nidn' => '0103018703', // Generated NIDN
                'email' => 'asrifah.suardi@kampus.ac.id'
            ],
            [
                'name' => 'Aulia Mutiara Hikmah, S.Si., M.Si',
                'position_name' => 'Ketua LPPM',
                'category' => 'Lembaga',
                'nidn' => '0104019004', // Generated NIDN
                'email' => 'aulia.hikmah@kampus.ac.id'
            ],
            [
                'name' => 'Rina Setyawati, S.Si., M.Pd',
                'position_name' => 'Ketua LPM',
                'category' => 'Lembaga',
                'nidn' => '0101018801', // Same person as D3 TLM
                'email' => 'rina.setyawati@kampus.ac.id'
            ],
            [
                'name' => 'Ns. Zalihin, S.Kep',
                'position_name' => 'Bagian Kemahasiswaan',
                'category' => 'Bagian',
                'nidn' => '0105018805', // Generated NIDN
                'email' => 'zalihin@kampus.ac.id'
            ],
            [
                'name' => 'Ns. Mubassir, S.Kep',
                'position_name' => 'Bagian Keuangan',
                'category' => 'Bagian',
                'nidn' => '0106018906', // Generated NIDN
                'email' => 'mubassir@kampus.ac.id'
            ]
        ];

        echo "=== ADDING NEW LECTURERS WITH STRUCTURAL POSITIONS ===\n\n";

        foreach ($newLecturers as $index => $lecturerData) {
            echo ($index + 1) . ". Processing: {$lecturerData['name']} - {$lecturerData['position_name']}\n";

            // Check if structural position exists, if not create it
            $structuralPosition = StructuralPosition::where('name', $lecturerData['position_name'])->first();
            
            if (!$structuralPosition) {
                $structuralPosition = StructuralPosition::create([
                    'name' => $lecturerData['position_name'],
                    'slug' => Str::slug($lecturerData['position_name']),
                    'description' => 'Posisi struktural ' . $lecturerData['position_name'],
                    'category' => $lecturerData['category'],
                    'level' => $this->getPositionLevel($lecturerData['category']),
                    'is_active' => true,
                    'sort_order' => $this->getSortOrder($lecturerData['category'])
                ]);
                echo "   ✓ Created structural position: {$lecturerData['position_name']}\n";
            } else {
                echo "   → Using existing structural position: {$lecturerData['position_name']}\n";
            }

            // Check if lecturer already exists (by NIDN)
            $existingLecturer = Lecturer::where('nidn', $lecturerData['nidn'])->first();
            
            if ($existingLecturer) {
                // Update existing lecturer with new structural position
                $existingLecturer->update([
                    'structural_position_id' => $structuralPosition->id,
                    'structural_start_date' => now(),
                    'structural_end_date' => null
                ]);
                echo "   → Updated existing lecturer with new position\n";
            } else {
                // Create new lecturer
                $lecturer = Lecturer::create([
                    'name' => $lecturerData['name'],
                    'nidn' => $lecturerData['nidn'],
                    'email' => $lecturerData['email'],
                    'phone' => null,
                    'gender' => 'L', // Default, can be updated later
                    'structural_position_id' => $structuralPosition->id,
                    'structural_start_date' => now(),
                    'structural_end_date' => null,
                    'is_active' => true
                ]);
                echo "   ✓ Created new lecturer: {$lecturerData['name']}\n";
            }

            echo "\n";
        }

        echo "=== ALL LECTURERS ADDED SUCCESSFULLY ===\n";
    }

    private function getPositionLevel($category)
    {
        return match($category) {
            'Rektor' => 1,
            'Lembaga' => 2,
            'Program Studi' => 3,
            'Bagian' => 4,
            default => 5
        };
    }

    private function getSortOrder($category)
    {
        return match($category) {
            'Rektor' => 10,
            'Lembaga' => 20,
            'Program Studi' => 30,
            'Bagian' => 40,
            default => 50
        };
    }

    private function getEducationLevel($name)
    {
        if (str_contains($name, 'M.Pd') || str_contains($name, 'M.M') || str_contains($name, 'M.Si') || str_contains($name, 'M.Sc')) {
            return 'S2';
        } elseif (str_contains($name, 'S.Si') || str_contains($name, 'S.Kep')) {
            return 'S1';
        }
        return 'S1'; // Default
    }
}
