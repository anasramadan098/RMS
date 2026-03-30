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
        Schema::create('competitors', function (Blueprint $table) {
            $table->id();


            $table->string('name');
            $table->string('location');
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('avg_price_range', 8, 2);



            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('linkedin')->nullable();


            $table->longText('strengths')->nullable();
            $table->longText('weaknesses')->nullable();




        
            $table->longText('notes')->nullable();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitors');
    }
};
