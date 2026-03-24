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

            // relations
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_id')->constrained()->onDelete('cascade');

            // les info dyal facture
            $table->string('invoice_number')->unique();

            // lflous
            $table->decimal('amount', 10, 2);
            $table->decimal('discount_applied', 8, 2)->default(0);
            $table->decimal('tax', 8, 2)->default(0);
            $table->decimal('total_paid', 10, 2);

            // kifach nkhlso
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer', 'check']);

            $table->string('transaction_id')->nullable();
            $table->date('payment_date');

            // lhala
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])
                  ->default('pending');

            // dkchi li knzido
            $table->text('notes')->nullable();
            $table->string('receipt_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};