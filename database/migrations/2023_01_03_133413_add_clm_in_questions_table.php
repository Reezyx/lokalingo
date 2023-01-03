<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClmInQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('answer')->change();
        });

        Schema::table('example_questions', function (Blueprint $table) {
            $table->string('answer')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->enum('answer', ['option_1', 'option_2', 'option_3', 'option_4', 'option_5'])->change();
        });

        Schema::table('example_questions', function (Blueprint $table) {
            $table->enum('answer', ['option_1', 'option_2', 'option_3', 'option_4', 'option_5'])->change();
        });
    }
}
