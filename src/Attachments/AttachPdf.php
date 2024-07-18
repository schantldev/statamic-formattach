<?php

namespace SchantlDev\Statamic\FormAttach\Attachments;

use Illuminate\Mail\Mailables\Attachment;
use SchantlDev\Statamic\FormAttach\Forms\SubmissionHelper;

class AttachPdf extends FormAttachment
{
    public string $size;

    public string $view;

    public function __construct(
        public SubmissionHelper $submissionHelper,
    ) {
        $this->size = config('statamic-formattach.format', 'A4');
        $this->view = 'statamic-formattach::pdf_attachment';
    }

    public function check(): bool
    {
        return class_exists(\Spatie\Browsershot\Browsershot::class);
    }

    public function attachment(): ?Attachment
    {
        return
            Attachment::fromData(fn () => $this->pdf(), $this->submissionHelper->subject().'.pdf')
                ->withMime('application/pdf');
    }

    public function view(bool $preview = false): string
    {
        return view($this->view, [
            'logo' => config('statamic-formattach.logo', null),
            'subject' => $this->submissionHelper->subject(),
            'submission' => $this->submissionHelper->data(),
            'blueprint' => $this->submissionHelper->blueprintFields(),
            'page_size' => config('statamic-formattach.format_sizes.'.$this->size),
            'preview' => $preview,
        ])->render();
    }

    public function pdf(): string
    {
        return
            \Spatie\Browsershot\Browsershot::html($this->view())
                ->format($this->size)
                ->pdf();
    }
}
