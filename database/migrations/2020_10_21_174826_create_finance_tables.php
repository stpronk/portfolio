<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_group', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);

            $table->unsignedBigInteger('owner_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('finance_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color');

            $table->unsignedBigInteger('finance_group_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('finance_group_id')->references('id')->on('finance_group')->onDelete('CASCADE');
        });

        Schema::create('finance_expense', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('type');
            $table->integer('amount');
            $table->date('date');
            $table->text('notes')->nullable();

            $table->unsignedBigInteger('finance_group_id');
            $table->unsignedBigInteger('finance_category_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('finance_group_id')->references('id')->on('finance_group')->onDelete('CASCADE');
            $table->foreign('finance_category_id')->references('id')->on('finance_category')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_expense');
        Schema::dropIfExists('finance_category');
        Schema::dropIfExists('finance_group');
    }
}
