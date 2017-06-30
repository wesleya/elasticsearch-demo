<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company')->nullable()->index();
            $table->string('product')->nullable()->index();
            $table->integer('count');
            $table->date('date_summarized')->index();
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
        Schema::drop('complaint_summaries');
    }
}
