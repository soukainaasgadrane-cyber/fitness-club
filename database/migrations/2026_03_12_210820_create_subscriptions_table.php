<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')->constrained()->onDelete('cascade');

            // plan
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->enum('plan_type', ['monthly', 'quarterly', 'yearly']);

            // pricing
            $table->decimal('price', 8, 2);
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('total_amount', 8, 2)->nullable();

            // dates
            $table->date('start_date');
            $table->date('end_date');
            $table->date('payment_due_date')->nullable();
            $table->date('payment_date')->nullable();

            // payment
            $table->enum('payment_status', ['paid', 'pending', 'overdue'])->default('pending');
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer'])->nullable();

            $table->string('invoice_number')->nullable()->unique();
            $table->text('payment_receipt')->nullable();
            $table->string('transaction_id')->nullable();

            // extra
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};