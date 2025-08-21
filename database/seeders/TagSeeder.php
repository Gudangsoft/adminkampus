<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            'teknologi',
            'pendidikan',
            'kampus',
            'mahasiswa',
            'penelitian',
            'inovasi',
            'akademik',
            'umum',
            'kompetisi',
            'digital'
        ];
        foreach ($tags as $tag) {
            Tag::updateOrCreate(
                ['slug' => Str::slug($tag)],
                [
                    'name' => $tag,
                    'slug' => Str::slug($tag),
                    'is_active' => true
                ]
            );
        }
    }
}
