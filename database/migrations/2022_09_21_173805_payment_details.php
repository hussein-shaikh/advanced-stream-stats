<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id');
            $table->string('transaction_id')->unique()->nullable();
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("package_id")->references("id")->on("packages");
            $table->float('amount');
            $table->string('payment_gateway', 50);
            $table->tinyInteger("payment_status")->default(0)->comment("0 initiated , 1 completed , 2 failed , 3 errord")->index();
            $table->softDeletes()->index();
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
        Schema::dropIfExists('payment_details');
    }
};
