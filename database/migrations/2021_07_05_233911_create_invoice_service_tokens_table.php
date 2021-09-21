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
            $table->foreignId("team_id")->references("id")->on("teams");
            $table->foreignId("app_id")->references("id")->on("invoice_services");
            $table->json('access_token');
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
        Schema::dropIfExists('invoice_service_tokens');
    }
}
