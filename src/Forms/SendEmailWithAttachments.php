<?php

namespace SchantlDev\Statamic\FormAttach\Forms;

use Illuminate\Support\Facades\Mail;
use Statamic\Forms\SendEmail;

class SendEmailWithAttachments extends SendEmail
{
    public function handle()
    {
        Mail::mailer($this->config['mailer'] ?? null)
            ->send(new Email($this->submission, $this->config, $this->site));
    }
}
