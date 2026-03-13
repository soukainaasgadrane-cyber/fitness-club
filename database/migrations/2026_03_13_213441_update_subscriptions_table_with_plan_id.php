<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            // إضافة plan_id
            $table->foreignId('plan_id')->nullable()->constrained('subscription_plans')->nullOnDelete();
            
            // تحديث الأعمدة الموجودة
            $table->decimal('amount_paid', 8, 2)->nullable(); // المبلغ المدفوع
            $table->decimal('remaining_amount', 8, 2)->default(0); // المبلغ المتبقي
            $table->enum('payment_status', ['paid', 'partial', 'pending', 'overdue'])->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn('plan_id');
            $table->dropColumn('amount_paid');
            $table->dropColumn('remaining_amount');
        });
    }
};