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
            $table->string('username')->nullable();
            $table->string('fullname');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_email_verified')->nullable();
            $table->string('role_id')->nullable();
            $table->bigInteger('verification_code')->nullable();
            $table->string('image')->nullable();
            $table->string('gender');
            $table->string('contact_no')->nullable();
            $table->string('address')->nullable();
            $table->char('login_type',50)->default('regular');
            $table->string('password')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->char('social_access_token',255)->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('ok_with_policy')->default(false);
            $table->unsignedBigInteger('shop_id');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

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
