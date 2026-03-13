<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // أساسي, محترف, VIP
            $table->enum('duration_type', ['monthly', 'quarterly', 'yearly']); // شهر, 3 شهور, سنة
            $table->integer('duration_months'); // 1, 3, 12
            $table->decimal('price', 8, 2); // السعر
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // المميزات (تخزين بصيغة JSON)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};