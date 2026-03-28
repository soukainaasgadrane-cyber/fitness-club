<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->unique()->after('id');
            $table->date('payment_due_date')->nullable()->after('end_date');
            $table->date('payment_date')->nullable()->after('payment_due_date');
            $table->decimal('discount', 8, 2)->default(0)->after('price');
            $table->decimal('total_amount', 8, 2)->after('discount');
            $table->text('payment_receipt')->nullable()->after('payment_method');
            $table->string('transaction_id')->nullable()->after('payment_receipt');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_number', 'payment_due_date', 'payment_date',
                'discount', 'total_amount', 'payment_receipt', 'transaction_id'
            ]);
        });
    }
};