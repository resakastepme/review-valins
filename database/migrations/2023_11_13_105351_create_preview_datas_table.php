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
        Schema::create('preview_datas', function (Blueprint $table) {
            $table->id();
            $table->String('timestamp_bawaan')->nullable();
            $table->string('witel');
            $table->integer('id_valins');
            $table->text('eviden1');
            $table->text('eviden2')->nullable();
            $table->text('eviden3')->nullable();
            $table->String('id_valins_lama')->nullable();
            $table->String('approve_aso')->nullable();
            $table->text('keterangan_aso')->nullable();
            $table->String('ram3')->nullable();
            $table->String('rekon')->nullable();
            $table->string('keterangan_ram3')->nullable();
            $table->String('upload_by')->nullable();
            $table->text('unique_id')->nullable();
            $table->boolean('isSubmit')->default(0);
            $table->boolean('isValid')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preview_datas');
    }
};
