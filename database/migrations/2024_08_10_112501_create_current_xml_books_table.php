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
        Schema::create('current_xml_books', function (Blueprint $table) {
            $table->id();
            $table->text('book_barcode_no')->nullable();
            $table->text('book_name')->nullable();
            $table->text('book_author_name')->nullable();
            $table->text('book_publisher_name')->nullable();
            $table->text('book_price')->nullable();
            $table->text('book_stock')->nullable();
            $table->text('book_image')->nullable();
            $table->text('book_description')->nullable();
            $table->text('xml_fetch_group')->nullable();
            $table->boolean('book_is_updated')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_xml_books');
    }
};
