<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnregisteredUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unregistered_users', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['email', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unregistered_users');
    }
}
