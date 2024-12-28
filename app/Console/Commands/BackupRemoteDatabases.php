<?php

namespace App\Console\Commands;

use App\Models\Configuration;
use App\Models\Connection;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BackupRemoteDatabases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup remote databases';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $connections = Connection::all();
        $config = Configuration::first();
        if ($config) {


            function limpiarTexto($texto)
            {
                // Eliminar caracteres no alfanuméricos (manteniendo espacios)
                $texto = preg_replace('/[^\w\s]/u', '', $texto);
                // Eliminar espacios extra (convertir múltiples espacios en uno solo)
                $texto = preg_replace('/\s+/', ' ', $texto);
                // Eliminar espacios
                $texto = trim($texto);
                $texto = str_replace(' ', '', $texto);
                return $texto;
            }

            foreach ($connections as $conn) {
                $folderName = limpiarTexto($conn['name']);
                [$ano, $mes] = [date('Y'), date('m')];

                $mainDir = $config->dir_path;
                $dirPath = "$mainDir/$folderName/$ano/$mes";
                if (!file_exists($dirPath)) {
                    mkdir($dirPath, 0777, true);
                }

                Log::info("Backing up database: {$conn['db_name']}");
                $comando = "{$config->dump_path} --skip-lock-tables ";
                $comando .= " -h {$conn['db_host']}";
                $comando .= " -u {$conn['db_user']}";
                $comando .= " -p'{$conn['db_password']}'";
                $comando .= " {$conn['db_name']}";
                $comando .= $config->compressor_path ? " | $config->compressor_path" : "";
                $comando .= " > {$dirPath}/{$conn['db_name']}_" . date('YmdHi') . ".sql";
                $comando .= $config->file_extension ? $config->file_extension : '';
                $comando .= " 2> $mainDir/$folderName/error.log";
                Log::info($comando);
                exec("$comando 2> $mainDir/error.log");
            }

            /* mariadb-dump -h [HOST] -u hardtv -p[PASSWORD] [DATABASE] | gzip > [MAIN_DIRECTORY]/database.sql.gz >> [MAIN_DIRECTORY]/error.log */
        }
    }
}
