<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendVerificationCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $verificationCode;

    public function __construct($user, $verificationCode)
    {
        $this->user = $user;
        $this->verificationCode = $verificationCode;
    }

    public function handle()
    {
        // Gửi email chứa mã xác minh cho người dùng
        // Mail::to($this->user->email)->send(new VerificationCodeEmail($this->verificationCode));
        Mail::send('mail.verification_code', ['user' => $this->user, 'verificationCode' => $this->verificationCode], function ($message) {
            $message->to($this->user->email)
                ->subject('Mã xác nhận tài khoản của bạn');
        });

    }
}
