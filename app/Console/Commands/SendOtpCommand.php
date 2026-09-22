<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

class SendOtpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send-otp {email : The recipient email address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a secure 6-digit OTP verification code via email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        // Simple validation of email address
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error("Invalid email address format: {$email}");
            return Command::FAILURE;
        }

        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        $this->info("Generating secure OTP: {$otp}...");
        $this->info("Sending OTP verification email to {$email}...");

        try {
            // Send the email using Mail facade
            Mail::to($email)->send(new SendOtpMail($otp));

            $this->newLine();
            $this->info("SUCCESS: OTP email has been sent successfully to {$email}!");
            $this->line("Verify code: <options=bold>{$otp}</>");
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->newLine();
            $this->error("FAILED: Could not send email. Error details: " . $e->getMessage());
            $this->line("Note: Please make sure your MAIL_* configurations in your .env file are set up correctly.");
            return Command::FAILURE;
        }
    }
}
