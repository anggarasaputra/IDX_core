<?php

use App\Models\Rooms;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('order_rooms')) {
            return;
        }

        Schema::create('order_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_room');
            $table->dateTime('awal')->nullable();
            $table->dateTime('akhir')->nullable();
            $table->text('qr')->nullable();
            $table->enum('status', Rooms::STATUS_ORDER);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_rooms');
    }
}
