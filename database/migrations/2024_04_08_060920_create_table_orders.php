<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_key')->unique();
            $table->string('type', 50);
            $table->string('status', 50);
            $table->json('response');
            $table->foreignId('email_id')->constrained(
                table: 'emails',
                indexName: 'order_email_id'
            )
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('event_id')->constrained(
                table: 'events',
                indexName: 'order_event_id'
            )
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
