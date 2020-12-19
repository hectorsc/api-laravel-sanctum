<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToProductsTable extends Migration
{
    public function up()
    {
        // creamos una categoria por defecto
        $category = new \App\Category();
        $category->name = 'Otros';
        $category->save(); //la persistimos en bbdd

        Schema::table('products', function (Blueprint $table) use ($category) {
            $table->unsignedBigInteger('category_id')->default($category->id);
            // creamos la clave foranea para mantener la integridad de datos en bbdd
            // al agregar el foreign me dio un error y tuve que instalar
            //composer require doctrine/dbal pero que tampoco solucinó el problema
            // lo solucioné borrando la bbdd y haciendo las migraciones otra vez
            $table->foreign('category_id')->references('id')->on('categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
}
