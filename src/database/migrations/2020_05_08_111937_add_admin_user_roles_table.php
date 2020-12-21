<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('resources');
            $table->timestamps();
        });

        Schema::table('admin_user', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->after('id')->nullable(true);
            $table->foreign('role_id')
                ->references('id')
                ->on('admin_user_role')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
