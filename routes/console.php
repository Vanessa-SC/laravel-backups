<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command(signature: 'inspire', callback: function (): void {
    Log::info(message: Inspiring::quote(). now());
})->purpose(description: 'Display an inspiring quote')->daily();

// Schedule::command(command: 'app:backup-db')->twiceDailyAt(first: 9, second: 4, offset: 15);
Schedule::command(command: 'app:backup-db')->cron('15 9 * * 1-5'); // Lunes a viernes 4:30 PM
Schedule::command(command: 'app:backup-db')->cron('30 16 * * 1-5'); // Lunes a viernes 4:30 PM
Schedule::command(command: 'app:backup-db')->cron('45 9 * * 6'); // Sabados 9:45 AM

// Setup crontab
// * * * * * cd /Users/usuario/Documents/Herd/Backups && php artisan schedule:run >> /dev/null 2>&1
