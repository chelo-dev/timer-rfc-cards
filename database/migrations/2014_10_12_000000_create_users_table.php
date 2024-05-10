<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('last_login')->nullable();
            $table->string('phone')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Nota:
     * Campo: is_active
     * 1 = activvo
     * 0 = inactivo
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
