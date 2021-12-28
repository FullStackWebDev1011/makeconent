<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
//    public function run()
//    {
//        // $this->call(UsersTableSeeder::class);
//
//    }
    public function run()
    {
        DB::table('categories')->insert([[
                'title' => 'Apple Pie',
                'q1_min'=>6,
                'q1_max'=>8,
                'q2_min'=>9,
                'q2_max'=>15,
                'q3_min'=>15,
                'q3_max'=>25,
            ],
            [
                'title' => 'Cup Cake',
                'q1_min'=>6,
                'q1_max'=>8,
                'q2_min'=>10,
                'q2_max'=>17,
                'q3_min'=>17,
                'q3_max'=>26,
            ]
        ]);

        DB::table('settings')->insert([[
                'title' => 'Apple Pie',
                'q1_min'=>6,
                'q1_max'=>8,
                'q2_min'=>9,
                'q2_max'=>15,
                'q3_min'=>15,
                'q3_max'=>25,
            ],
        ]);

        DB::table('user_level')->insert([[
                'levelType' => 'admin',
                'name'=>'Admin',
                'description'=>'',
                'menu_role'=>'["Marketplace","Financial","Members","Projects","CategoryEditor","TaxOffices","Countries","BonusCode","Disputes","AllMessages","Documents","Statistics","UserManager","UserLevel","ServiceLogs","SettingGlobal","SettingsGlobal"]',
                'status'=>'active',
            ],
            [
                'levelType' => 'copywriter',
                'name'=>'Copywriter',
                'description'=>'',
                'menu_role'=>'["Marketplace","BrowseJobs","Financial","Affiliate","Messanges"]',
                'status'=>'active',
            ],
            [
                'levelType' => 'client',
                'name'=>'Client',
                'description'=>'',
                'menu_role'=>'["Marketplace","Order","Financial","Affiliate","Messanges","BrowseCopywriter"]',
                'status'=>'active',
            ]
        ]);
    }
}
