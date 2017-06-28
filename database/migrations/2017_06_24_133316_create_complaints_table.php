<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date_received')->index();
            $table->string('product')->nullable()->index();
            $table->string('sub_product')->nullable();
            $table->string('issue')->nullable();
            $table->string('sub_issue')->nullable();
            $table->text('complaint_what_happened')->nullable()->index();
            $table->text('company_public_response')->nullable();
            $table->string('company')->nullable()->index();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('tags')->nullable();
            $table->string('consumer_consent_provided')->nullable();
            $table->string('submitted_via')->nullable();
            $table->dateTime('date_sent_to_company');
            $table->text('company_response')->nullable();
            $table->string('timely')->nullable();
            $table->string('consumer_disputed')->nullable();
            $table->integer('complaint_id')->unique();
            $table->integer('what_happened_count')->nullable();
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
        Schema::drop('complaints');
    }
}
