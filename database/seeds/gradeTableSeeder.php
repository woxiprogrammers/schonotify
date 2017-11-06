<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class gradeTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('grade')->insert([
            'class_id'=> 12,
            'min'=>90,
            'max'=>100,
            'grade'=>'A+(outstanding)',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ],
            [
                'class_id'=> 12,
                'min'=>75,
                'max'=>89,
                'grade'=>'A(Excellent)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 12,
                'min'=>56,
                'max'=>74,
                'grade'=>'B(Very Good)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 12,
                'min'=>35,
                'max'=>55,
                'grade'=>'C(Good)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 12,
                'min'=>0,
                'max'=>34,
                'grade'=>'D(Average)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 13,
                'min'=>90,
                'max'=>100,
                'grade'=>'A+(outstanding)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 13,
                'min'=>75,
                'max'=>89,
                'grade'=>'A(Excellent)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 13,
                'min'=>56,
                'max'=>74,
                'grade'=>'B(Very Good)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 13,
                'min'=>35,
                'max'=>55,
                'grade'=>'C(Good)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 13,
                'min'=>0,
                'max'=>34,
                'grade'=>'D(Average)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 14,
                'min'=>91,
                'max'=>100,
                'grade'=>'A1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 14,
                'min'=>81,
                'max'=>90,
                'grade'=>'A2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 14,
                'min'=>71,
                'max'=>80,
                'grade'=>'B1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 14,
                'min'=>61,
                'max'=>70,
                'grade'=>'B2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 14,
                'min'=>51,
                'max'=>60,
                'grade'=>'C1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 14,
                'min'=>41,
                'max'=>50,
                'grade'=>'C2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 14,
                'min'=>33,
                'max'=>40,
                'grade'=>'D',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 14,
                'min'=>0,
                'max'=>32,
                'grade'=>'E(Failed)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 15,
                'min'=>91,
                'max'=>100,
                'grade'=>'A1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 15,
                'min'=>81,
                'max'=>90,
                'grade'=>'A2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 15,
                'min'=>71,
                'max'=>80,
                'grade'=>'B1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 15,
                'min'=>61,
                'max'=>70,
                'grade'=>'B2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 15,
                'min'=>51,
                'max'=>60,
                'grade'=>'C1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 15,
                'min'=>41,
                'max'=>50,
                'grade'=>'C2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 15,
                'min'=>33,
                'max'=>40,
                'grade'=>'D',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 15,
                'min'=>0,
                'max'=>32,
                'grade'=>'E(Failed)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 16,
                'min'=>91,
                'max'=>100,
                'grade'=>'A1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 16,
                'min'=>81,
                'max'=>90,
                'grade'=>'A2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 16,
                'min'=>71,
                'max'=>80,
                'grade'=>'B1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 16,
                'min'=>61,
                'max'=>70,
                'grade'=>'B2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 16,
                'min'=>51,
                'max'=>60,
                'grade'=>'C1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 16,
                'min'=>41,
                'max'=>50,
                'grade'=>'C2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 16,
                'min'=>33,
                'max'=>40,
                'grade'=>'D',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 16,
                'min'=>0,
                'max'=>32,
                'grade'=>'E(Failed)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 17,
                'min'=>91,
                'max'=>100,
                'grade'=>'A1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 17,
                'min'=>81,
                'max'=>90,
                'grade'=>'A2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 17,
                'min'=>71,
                'max'=>80,
                'grade'=>'B1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 17,
                'min'=>61,
                'max'=>70,
                'grade'=>'B2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 17,
                'min'=>51,
                'max'=>60,
                'grade'=>'C1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 17,
                'min'=>41,
                'max'=>50,
                'grade'=>'C2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 17,
                'min'=>33,
                'max'=>40,
                'grade'=>'D',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 17,
                'min'=>0,
                'max'=>32,
                'grade'=>'E(Failed)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 18,
                'min'=>91,
                'max'=>100,
                'grade'=>'A1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 18,
                'min'=>81,
                'max'=>90,
                'grade'=>'A2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 18,
                'min'=>71,
                'max'=>80,
                'grade'=>'B1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 18,
                'min'=>61,
                'max'=>70,
                'grade'=>'B2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 18,
                'min'=>51,
                'max'=>60,
                'grade'=>'C1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 18,
                'min'=>41,
                'max'=>50,
                'grade'=>'C2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 18,
                'min'=>33,
                'max'=>40,
                'grade'=>'D',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 18,
                'min'=>0,
                'max'=>32,
                'grade'=>'E(Failed)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 19,
                'min'=>91,
                'max'=>100,
                'grade'=>'A1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 19,
                'min'=>81,
                'max'=>90,
                'grade'=>'A2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 19,
                'min'=>71,
                'max'=>80,
                'grade'=>'B1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 19,
                'min'=>61,
                'max'=>70,
                'grade'=>'B2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 19,
                'min'=>51,
                'max'=>60,
                'grade'=>'C1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 19,
                'min'=>41,
                'max'=>50,
                'grade'=>'C2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 19,
                'min'=>33,
                'max'=>40,
                'grade'=>'D',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 19,
                'min'=>0,
                'max'=>32,
                'grade'=>'E(Failed)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 37,
                'min'=>91,
                'max'=>100,
                'grade'=>'A1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 37,
                'min'=>81,
                'max'=>90,
                'grade'=>'A2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 37,
                'min'=>71,
                'max'=>80,
                'grade'=>'B1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 37,
                'min'=>61,
                'max'=>70,
                'grade'=>'B2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 37,
                'min'=>51,
                'max'=>60,
                'grade'=>'C1',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 37,
                'min'=>41,
                'max'=>50,
                'grade'=>'C2',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 37,
                'min'=>33,
                'max'=>40,
                'grade'=>'D',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'class_id'=> 37,
                'min'=>0,
                'max'=>32,
                'grade'=>'E(Failed)',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
    }
}
