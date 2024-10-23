<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // Para o campo "id"
            $table->string('title'); // Para o campo "title"
            $table->text('content'); // Para o campo "content"
            $table->unsignedBigInteger('author_id'); // Para o campo "author_id"
            $table->timestamps(); // Para os campos "created_at" e "updated_at"
            
            // Chave estrangeira, assumindo que existe uma tabela 'authors' ou 'users'
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};


