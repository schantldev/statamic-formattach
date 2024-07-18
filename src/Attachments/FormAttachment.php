<?php

namespace SchantlDev\Statamic\FormAttach\Attachments;

use Illuminate\Mail\Mailables\Attachment;
use SchantlDev\Statamic\FormAttach\Forms\SubmissionHelper;

abstract class FormAttachment
{
    public function __construct(
        public SubmissionHelper $submissionHelper
    ) {
        // ignore
    }

    public function __invoke(): ?Attachment
    {
        if (! $this->check()) {
            return null;
        }

        return $this->attachment();
    }

    public function check(): bool
    {
        return true;
    }

    abstract public function attachment(): ?Attachment;
}
