<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class UpdateController extends Controller
{
    public function index()
    {
        return $this->update_1_2_to_2_0();
    }

    public function update_1_2_to_2_0()
    {
        Artisan::call('config:clear');

        if (Schema::hasTable('updates'))
        {
            $updateCheck = DB::table('updates')->orderBy('id', 'DESC')->first();
            $updateCheck = $updateCheck->new_version;
            if($updateCheck == "V 2.0"){
                return 'Congrats !!! <br>You are already using a updated version.<br><button onclick="goBack()">Go Back</button>
                <script>
                function goBack() {
                  window.history.back();
                }
                </script>';
            }
        } else {
            Schema::table('patient_appointments', function (Blueprint $table) {
                $table->unsignedBigInteger('company_id')->nullable()->default("1");
            });
        }

        if (!Schema::hasTable('updates')) {
            Schema::create('updates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('launched');
            $table->string('old_version')->nullable();
            $table->string('new_version');
            $table->text('description')->nullable();
            $table->enum('status', ['0', '1', '2'])->default('1');
            $table->timestamps();
            });

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

            echo "Success : [updates] table created successfully.<br>";
        } else {
            return 'Error : [updates] this update has already done.<br><button onclick="goBack()">Go Back</button>
                <script>
                function goBack() {
                  window.history.back();
                }
                </script>';
        }
    }
}
