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
        Schema::create('order_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->foreignId('order_id')->constrained('orders');
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
