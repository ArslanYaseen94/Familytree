<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('tbl_admin')) {
            return;
        }

        Schema::create('tbl_admin', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();

            $table->string('phone')->nullable();
            $table->text('bio')->nullable();

            $table->unsignedTinyInteger('Status')->default(0);
            $table->string('language')->nullable();

            $table->string('company_name')->nullable();
            $table->string('dba_name')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('fax')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_admin');
    }
};

