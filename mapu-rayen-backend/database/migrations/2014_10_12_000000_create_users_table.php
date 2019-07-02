<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprises', function (Blueprint $table){
         $table->increments('id');
         $table->string('name');
         $table->text('description')->nullable();
         $table->string('email');
         $table->timestamps();
       });
       //Estos son los permisos que valida el sistema realmente, no los roles.
       Schema::create('permissions', function (Blueprint $table){
         $table->increments('id');
         $table->string('name');
         $table->text('description')->nullable();
         $table->timestamps();
       });
       Schema::create('roles', function (Blueprint $table){
         $table->increments('id');
         $table->unsignedInteger('enterprise_id');
         $table->string('name');
         $table->text('description')->nullable();
         $table->timestamps();
       });
       Schema::create('permissions_roles', function (Blueprint $table){
         $table->unsignedInteger('permission_id');
         $table->unsignedInteger('role_id');

         $table->foreign('permission_id')->references('id')->on('permissions');
         $table->foreign('role_id')->references('id')->on('roles');
       });
        Schema::create('users', function (Blueprint $table) {
         $table->increments('id');
         $table->unsignedInteger('enterprise_id');
         $table->unsignedInteger('role_id')->default(1);
         $table->string('name');
         $table->string('last_name')->nullable();
         $table->string('email')->unique();
         $table->timestamp('email_verified_at')->nullable();
         $table->string('password');
         $table->string('slug');
         $table->rememberToken();

         //Timestamps
         $table->timestamps();

         //foreings
         $table->foreign('enterprise_id')->references('id')->on('enterprises');
         $table->foreign('role_id')->references('id')->on('roles');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprises');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions_roles');
        Schema::dropIfExists('users');
    }
}
