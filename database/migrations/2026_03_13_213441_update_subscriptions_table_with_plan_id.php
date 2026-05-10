<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('subscriptions', 'plan_id')) {
                $table->foreignId('plan_id')->nullable()->constrained('subscription_plans')->nullOnDelete();
            } else {
                $table->foreign('plan_id')->references('id')->on('subscription_plans')->nullOnDelete();
            }

            if (!Schema::hasColumn('subscriptions', 'amount_paid')) {
                $table->decimal('amount_paid', 8, 2)->nullable();
            }

            if (!Schema::hasColumn('subscriptions', 'remaining_amount')) {
                $table->decimal('remaining_amount', 8, 2)->default(0);
            }
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