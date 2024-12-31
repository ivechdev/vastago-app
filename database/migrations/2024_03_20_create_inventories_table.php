<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('products')) {
            Schema::create('inventories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->decimal('quantity', 10, 2)->default(0);
                $table->decimal('minimum_stock', 10, 2)->default(0);
                $table->string('unit')->default('unidad'); // kg, l, unidad, etc.
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        } else {
            throw new Exception('La tabla de productos no existe. Asegúrate de que la migración de productos se ejecute primero.');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
