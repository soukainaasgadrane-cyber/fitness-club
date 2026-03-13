<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number')->unique(); // رقم الفاتورة
            $table->foreignId('subscription_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained();
            $table->foreignId('user_id')->constrained(); // الموظف اللي استلم الفلوس
            $table->decimal('amount', 8, 2);
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer', 'check']);
            $table->enum('payment_type', ['full', 'partial', 'installment'])->default('full');
            $table->string('transaction_id')->nullable(); // رقم العملية (للبطاقة)
            $table->string('check_number')->nullable(); // رقم الشيك
            $table->date('payment_date');
            $table->text('notes')->nullable();
            $table->enum('status', ['completed', 'pending', 'failed', 'refunded'])->default('completed');
            $table->string('receipt_path')->nullable(); // مسار وصل الدفع
            $table->timestamps();

            // Indexes
            $table->index('payment_number');
            $table->index('payment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};