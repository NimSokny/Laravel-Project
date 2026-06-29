<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::statement('ALTER TABLE products DROP FOREIGN KEY products_brand_id_foreign');
        } catch (\Exception $e) {
            // Foreign key might not exist or have different name
        }
        
        DB::statement('ALTER TABLE products ADD CONSTRAINT products_brand_id_foreign FOREIGN KEY (brand_id) REFERENCES brands(id) ON UPDATE CASCADE ON DELETE CASCADE');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE products DROP FOREIGN KEY products_brand_id_foreign');
        } catch (\Exception $e) {
            // Foreign key might not exist or have different name
        }
        
        DB::statement('ALTER TABLE products ADD CONSTRAINT products_brand_id_foreign FOREIGN KEY (brand_id) REFERENCES brands(id) ON UPDATE CASCADE ON DELETE RESTRICT');
    }
};
