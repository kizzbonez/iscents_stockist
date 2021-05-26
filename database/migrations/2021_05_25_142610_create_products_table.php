<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('sku')->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->float('price')->default(0);
            $table->float('points')->default(0);
            $table->dateTime('archived_at')->nullable();
            $table->unsignedBigInteger('archived_by')->nullable();
            $table->foreign('archived_by')
                ->references('id')->on('users_stockist')
                ->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')
                ->references('id')->on('users_stockist')
                ->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')
                ->references('id')->on('users_stockist')
                ->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
