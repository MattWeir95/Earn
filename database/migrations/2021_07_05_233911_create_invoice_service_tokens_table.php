<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceServiceTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_service_tokens', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('team_id')->unsigned();
            $table->bigInteger('app_id')->unsigned();
            $table->string('api_id');
            $table->string('app_name');
            $table->json('access_token');
            $table->timestamps();
            $table->foreign("team_id")->references("id")->on("teams");
            $table->foreign("app_id")->references("id")->on("invoice_services");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_service_tokens');
    }
}
