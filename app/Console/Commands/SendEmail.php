<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\User;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Commant send Email to Active users Every Hour';
    /**
     * Execute the console command.$
     *
     * @return int
     */
    public function handle()
    {
        $message = 'Hello Test Users, This ios Test Email from Rana87330 Assignment';
        $users = User::where("active","Yes")->get();
        foreach ($users as $user) {
            Mail::raw($message, function ($mail) use ($user) {
                $mail->from('rana87330@gmail.com');
                $mail->to($user->email)
                    ->subject('Test Assignment Mail');
            });
        }
        $this->info('Mail has been sent Successfully to active Users');
    }
}
