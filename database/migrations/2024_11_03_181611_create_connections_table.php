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
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('db_host');
            $table->string('db_user');
            $table->string('db_password');
            $table->string('db_name');
            $table->timestamps();
        });
        /* 
        -h 3.139.34.235 
        -u root 
        -pN3xUsT4basc020xX 
        nexus_tabasco */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connections');
    }
};
