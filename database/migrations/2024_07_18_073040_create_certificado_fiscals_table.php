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
        Schema::create('certificado_fiscals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('estatus')->default(1);
            $table->unsignedTinyInteger('empresa_id')->nullable(false)->default(0);

            $table->text("csd")->nullable(false);
            $table->text("llave_privada")->nullable(false);
            $table->string("csd_password")->nullable(false)->default("csd_password");
        });


        Artisan::call('db:seed', [
            '--class' => 'Database\Seeders\CertificadoFiscalSeeder',
            '--force' => true 
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificado_fiscals');
    }
};
