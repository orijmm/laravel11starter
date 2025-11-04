<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Solo ejecuta si estamos usando MySQL
        if (DB::getDriverName() === 'mysql') {
            // === PRODUCTS ===
            Schema::table('products', function ($table) {
                // Columnas virtuales derivadas del JSON (si no existen)
                DB::statement('
                    ALTER TABLE products
                    ADD COLUMN color VARCHAR(50)
                        GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(specs, "$.color"))) STORED,
                    ADD COLUMN size VARCHAR(50)
                        GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(specs, "$.size"))) STORED,
                    ADD COLUMN brand_name VARCHAR(100)
                        GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(specs, "$.brand"))) STORED
                ');
            });

            // Índices para búsquedas más rápidas
            DB::statement('CREATE INDEX idx_products_color ON products (color)');
            DB::statement('CREATE INDEX idx_products_size ON products (size)');
            DB::statement('CREATE INDEX idx_products_brand_name ON products (brand_name)');

            // === VARIANTS ===
            Schema::table('product_variants', function ($table) {
                DB::statement('
                    ALTER TABLE product_variants
                    ADD COLUMN color VARCHAR(50)
                        GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(specs, "$.color"))) STORED,
                    ADD COLUMN size VARCHAR(50)
                        GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(specs, "$.size"))) STORED
                ');
            });

            DB::statement('CREATE INDEX idx_product_variants_color ON product_variants (color)');
            DB::statement('CREATE INDEX idx_product_variants_size ON product_variants (size)');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            // Eliminar índices
            DB::statement('DROP INDEX idx_products_color ON products');
            DB::statement('DROP INDEX idx_products_size ON products');
            DB::statement('DROP INDEX idx_products_brand_name ON products');

            DB::statement('DROP INDEX idx_product_variants_color ON product_variants');
            DB::statement('DROP INDEX idx_product_variants_size ON product_variants');

            // Eliminar columnas virtuales
            Schema::table('products', function ($table) {
                $table->dropColumn(['color', 'size', 'brand_name']);
            });

            Schema::table('product_variants', function ($table) {
                $table->dropColumn(['color', 'size']);
            });
        }
    }
};
