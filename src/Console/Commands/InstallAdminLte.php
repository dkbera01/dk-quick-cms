<?php

namespace DK\QuickCms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Artisan;

class InstallAdminLte extends Command
{
    protected $signature = 'install:adminlte';
    protected $description = 'Install AdminLTE and its assets via npm';

    public function handle()
    {
        // Run npm install admin-lte
        $this->info('Running npm install admin-lte...');
        $process = new Process(['npm', 'install', 'admin-lte']);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Error during npm install admin-lte');
            return 1;
        }

        $this->info('AdminLTE installed successfully.');

        $this->info('Running breeze install...');
        Artisan::call('breeze:install');
         $this->info('breeze installed successfully.');

        // $email = $this->ask('Enter the admin email');
        // $password = $this->secret('Enter the admin password');

        // Publish package migrations
        Artisan::call('vendor:publish', ['--tag' => 'migrations']);
        Artisan::call('vendor:publish', ['--tag' => 'views']);

        // // Run package migrations
        // Artisan::call('migrate');

        // // Create admin user
        // $this->createAdminUser($email, $password);

        return 0;
    }

    protected function createAdminUser($email, $password)
    {
        DB::table('users')->updateOrInsert(
            ['email' => $email],
            [
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );
    }

}
