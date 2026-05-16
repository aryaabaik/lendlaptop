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
    Schema::create('returns', function (Blueprint $table) {
        $table->id();
        $table->foreignId('borrowing_id')->constrained()->onDelete('cascade');
        $table->enum('condition_after', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
        $table->decimal('fine', 10, 2)->default(0);
        $table->text('note')->nullable();
        $table->timestamps();
    });
}   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
