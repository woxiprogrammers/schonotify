<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StudentsDocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('student_documents_list')->insert([
            [
                'document_name' => 'Birth certificate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'document_name' => 'Leaving certificate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'document_name' => 'Report card of previous school',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'document_name' => 'Aadhar card of child',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'document_name' => 'Caste certificate if applicable',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'document_name' => 'ID card size photo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ]
        ]);
    }
}
