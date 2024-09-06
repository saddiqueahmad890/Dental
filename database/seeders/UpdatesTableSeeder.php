<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UpdatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('updates')->insert(
            array(
                   'name'   =>   'V 1.0',
                   'launched'     =>   '1 February 2022',
                   'old_version'     =>   'Not Available',
                   'new_version'     =>   'V 1.0',
                   'description'     =>   'Initial Release',
                   'created_at'      => date('Y-m-d H:i:s'),
                   'updated_at'      => date('Y-m-d H:i:s'),
                   'status'     =>   '1',
            )
       );

        DB::table('updates')->insert(
            array(
                'name'   =>   'V 1.1',
                'launched'     =>   '24 February 2022',
                'old_version'     =>   'V 1.0',
                'new_version'     =>   'V 1.1',
                'description'     =>   'RTL Support, Arabic Support, Front-end Language Support',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
                'status'     =>   '1',
            )
        );

        DB::table('updates')->insert(
            array(
                'name'   =>   'V 1.2',
                'launched'     =>   '1 September 2022',
                'old_version'     =>   'V 1.1',
                'new_version'     =>   'V 1.2',
                'description'     =>   'Add file or image file on patient case study, Role Change for doctor, Invoice select problem solved',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
                'status'     =>   '1',
            )
        );

        DB::table('updates')->insert(
            array(
                'name'   =>   'V 2.0',
                'launched'     =>   '1 April 2023',
                'old_version'     =>   'V 1.2',
                'new_version'     =>   'V 2.0',
                'description'     =>   'Install problem solved, image & file upload issue solved, Add Role Base Permission, Add Calender Appointment view for Doctor & Patient',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
                'status'     =>   '1',
            )
        );
    }
}
