<?php

use App\Models\Configuration;
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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('dir_path')->comment('Path to save in local disk the final backup file')->default('/Users/usuario/Documents/backups');
            $table->string('dump_path')->comment('Path to mysqldump or mariadb-dump command')->default('/opt/homebrew/opt/mariadb/bin/mariadb-dump');
            $table->string('compressor_path')->comment('Path where the compressor command is located')->default('/usr/bin/gzip')->nullable();
            $table->string('file_extension')->comment('Extension for backup file after being compressed')->default('.gz')->nullable();
            $table->timestamps();
        });

        Configuration::create([
            'dir_path' => '/Users/usuario/Documents/backups',
            'dump_path' => '/opt/homebrew/opt/mariadb@11.2/bin/mariadb-dump',
            'compressor_path' => '/usr/bin/gzip',
            'file_extension' => '.gz',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
