<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('polimenu_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');                               // Nome del menu
            $table->string('handle')->unique();                   // Handle univoco del menu
            $table->json('items');                              // Campo JSON per gli items
            $table->boolean('is_published')->default(true);     // Stato di pubblicazione
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polimenu_table');
    }
};
