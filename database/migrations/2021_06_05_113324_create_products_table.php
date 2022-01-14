<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('location');
            $table->text('reported_by')->nullable();
            $table->text('serial')->nullable();
            $table->longText('images')->nullable();
            $table->longText('description')->nullable();
            $table->longText('parts')->nullable();
            $table->boolean('audited')->default(false);
//            $table->boolean('internal')->default(false);
            $table->foreignId('client_id')->nullable()
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_status_id')->nullable()
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('problem_type_id')->nullable()
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamp('claimed_at')->nullable()->default(null);
            $table->timestamp('finished_at')->nullable()->default(null);
            $table->timestamp('reported_at')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
