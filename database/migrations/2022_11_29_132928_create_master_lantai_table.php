<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterLantaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('master_lantai')) {
            return;
        }

        Schema::create('master_lantai', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Nama dari lantai tsb, lantai ke berapa dapat dilihat dari kolom id');
            $table->tinyInteger('active')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('master_lantai');
    }
}
