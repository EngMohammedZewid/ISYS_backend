<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateUserQrCodesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-user-qr-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            try {
                $user->generateQrCode();
                $this->info("QR code generated for user '{$user->email}'.");
            } catch (\Exception $e) {
                $this->error("Error generating QR code for user '{$user->email}': {$e->getMessage()}");
            }
        }

        return 0;
    }
}
