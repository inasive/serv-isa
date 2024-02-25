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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('admin')->default(0);
            $table->string('imagen')->nullable();
            $table->string('img_id')->nullable();
            $table->string('telefono')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            // $table->dropColumn('admin');
            // $table->dropColumn('imagen');
            // $table->dropColumn('img_id');
            // $table->dropColumn('telefono');
        });
    }
};
