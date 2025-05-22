<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataFaq = [
            [
                'question' => 'Apakah membuat undangan digital gratis?',
                'answer' => 'Undangan website Satu Momen gratis selama masa uji coba (free trial) 12 jam setelah itu kamu dapat memilih paket yang tersedia.',
                'lang' => 'ID',
                'parent_id' => null,
                'status' => 'Publish',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'question' => 'Is creating digital invitations free ?',
                'answer' => 'There are no limits to sending digital invitations on the Satu Momen website. Just one invitation for many guests.',
                'lang' => 'EN',
                'parent_id' => 1,
                'status' => 'Publish',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Faq::insert($dataFaq);
    }
}
