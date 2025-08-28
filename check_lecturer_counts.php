<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\StudyProgram;
use App\Models\Lecturer;

echo "Study Programs:\n";
foreach(StudyProgram::all() as $sp) {
    echo "- {$sp->name} (ID: {$sp->id})\n";
}

echo "\nLecturers with their active status:\n";
foreach(Lecturer::all() as $lecturer) {
    $studyProgramIds = $lecturer->study_program_ids ?: [];
    $activeStatus = $lecturer->is_active ? 'ACTIVE' : 'INACTIVE';
    echo "- {$lecturer->name} - Study Program IDs: " . json_encode($studyProgramIds) . " - Status: {$activeStatus}\n";
}

echo "\nLecturer count per study program (without active filter):\n";
foreach(StudyProgram::all() as $sp) {
    $lecturerCount = Lecturer::where(function ($query) use ($sp) {
        $query->whereJsonContains('study_program_ids', $sp->id)
              ->orWhereJsonContains('study_program_ids', (string) $sp->id);
    })
    ->count();
    echo "- {$sp->name}: {$lecturerCount} lecturers\n";
}

echo "\nFinal lecturer count per study program (LIKE query):\n";
foreach(StudyProgram::all() as $sp) {
    $lecturerCount = Lecturer::where('study_program_ids', 'LIKE', '%' . $sp->id . '%')
                            ->where('is_active', true)
                            ->count();
    echo "- {$sp->name}: {$lecturerCount} lecturers\n";
}
