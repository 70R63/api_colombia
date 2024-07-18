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
        Schema::dropIfExists('pac_servicios');
        
        Schema::create('pac_servicios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('estatus')->default(1);
            $table->unsignedTinyInteger('empresa_id')->nullable(false)->default(0);
            $table->string("descripcion")->nullable(false)->default("descripcion");

            $table->unsignedTinyInteger('tipo')->nullable(false)->default(0);
            $table->string("uri")->nullable(false)->default("uri");
            $table->string("usuario")->nullable(false)->default("usuario");
            $table->string("password")->nullable(false)->default("password");
            $table->text("token")->nullable(false);


        });


        Artisan::call('db:seed', [
            '--class' => 'Database\Seeders\PacServicioSeeder',
            '--force' => true 
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pac_servicios');
    }
};
