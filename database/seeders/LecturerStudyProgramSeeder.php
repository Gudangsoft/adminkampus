<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lecturer;
use App\Models\StudyProgram;

class LecturerStudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lecturers = Lecturer::all();
        $tikProgram = StudyProgram::where('code', 'TIK')->first();
        $siProgram = StudyProgram::where('code', 'SI')->first();
        $manajemenProgram = StudyProgram::where('code', 'MAN')->first();

        foreach($lecturers as $lecturer) {
            if($lecturer->faculty_id == 1) { // FTI faculty
                $lecturer->studyPrograms()->attach([$tikProgram->id, $siProgram->id]);
            } else { // FEB faculty
                $lecturer->studyPrograms()->attach([$manajemenProgram->id]);
            }
        }
    }
}
