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
        Schema::create('users_stockist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('address')->nullable();
            $table->integer('city')->nullable();
            $table->integer('province')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('menuroles');
            $table->integer('stockist_type_id')->comment('0-main , 1-Provincial, 2-Municipal, 3-Mobile')->nullable()->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

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
