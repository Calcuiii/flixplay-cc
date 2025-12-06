<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->enum('subscription_type', ['monthly', 'yearly'])->default('monthly');
            $table->timestamp('expires_at')->nullable();
            $table->string('midtrans_transaction_id')->nullable()->unique();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};