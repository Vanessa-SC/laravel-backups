<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command(signature: 'inspire', callback: function (): void {
    Log::info(message: Inspiring::quote(). now());
})->purpose(description: 'Display an inspiring quote')->daily();

Artisan::command(signature: 'zip', callback: function (): void {
    $results = [];
    $path = '/Users/usuario/Documents/backups';
    $folders = array_diff(scandir($path), ['..', '.', '.DS_Store']);
    foreach ($folders as $folder) {
        $folderPath = "$path/$folder";
        if (is_file($folderPath) && !str_contains($folderPath, '.log'))
            $results[] = $folderPath;
        if (!is_dir($folderPath))
            continue;
        $anios = array_diff(scandir($folderPath), ['..', '.', '.DS_Store']);
        foreach ($anios as $anio) {
            $folderPath = "$path/$folder/$anio";
            if (is_file($folderPath) && !str_contains($folderPath, '.log'))
                $results[] = $folderPath;
            if (!is_dir($folderPath))
                continue;
            $meses = array_diff(scandir($folderPath), ['..', '.', '.DS_Store']);
            foreach ($meses as $mes) {
                $folderPath = "$path/$folder/$anio/$mes";
                if (is_file($folderPath) && !str_contains($folderPath, '.log'))
                    $results[] = $folderPath;
                if (!is_dir($folderPath))
                    continue;
                $backups = array_diff(scandir($folderPath), ['..', '.', '.DS_Store']);
                foreach ($backups as $backup) {
                    $filePath = "$path/$folder/$anio/$mes/$backup";
                    if (str_contains($backup, '.gz') || str_contains($backup, '.zip') || str_contains($backup, '.rar') || str_contains($backup, '.log'))
                        continue;
                    $results[] = $filePath;
                    Log::info(message: $filePath);
                    exec("gzip $filePath");
                }
            }
        }
    }
})->dailyAt('11:31');

// Schedule::command(command: 'app:backup-db')->twiceDailyAt(first: 9, second: 4, offset: 15);
// Schedule::command(command: 'app:backup-db')->cron('15 9 * * 1-5'); // Lunes a viernes 4:30 PM
Schedule::command(command: 'app:backup-db')->dailyAt('10:10'); // 9:15 AM
Schedule::command(command: 'app:backup-db')->dailyAt('9:17'); // 9:15 AM
Schedule::command(command: 'app:backup-db')->dailyAt('3:45'); // 3:45 PM
Schedule::command(command: 'app:backup-db')->dailyAt('16:05'); // 3:45 PM
Schedule::command(command: 'app:backup-db')->weeklyOn(6, '9:45'); // Sabados 9:45 AM
Schedule::command(command: 'app:backup-db')->weeklyOn(6, '1:00'); // Sabados 1:00 PM
Schedule::command(command: 'app:backup-db')->weeklyOn(7, '22:03'); // Sabados 1:00 PM
// Setup crontab
// * * * * * cd /Users/usuario/Documents/Herd/Backups && php artisan schedule:run >> /dev/null 2>&1
