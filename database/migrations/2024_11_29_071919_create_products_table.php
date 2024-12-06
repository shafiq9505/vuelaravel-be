<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
    {
    public function up()
        {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Product name
            $table->text('description'); // Product description
            $table->decimal('price', 8, 2); // Product price (max 8 digits, 2 decimals)
            $table->integer('quantity'); // Available quantity
            $table->string('image')->nullable(); // Product image URL
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key (user_id)
            $table->timestamps(); // Created at, Updated at timestamps
            });
        }

    public function down()
        {
        Schema::dropIfExists('products');
        }
    }


