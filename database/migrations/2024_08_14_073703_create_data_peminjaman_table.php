<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_peminjaman');
            $table->date('tgl_pengembalian');
            $table->string('nama_peminjam');
            $table->json('kode_barang')->nullable(); // Menyimpan array ID barang
            $table->json('kode_ruangan')->nullable(); // Menyimpan array ID ruangan
            $table->integer('jumlah')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes(); // Menambahkan fitur soft delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_peminjaman');
    }
}
