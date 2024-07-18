<?php

namespace SchantlDev\Statamic\FormAttach\Forms;

use Statamic\Contracts\Forms\Submission;
use Statamic\Forms\Email as FormsEmail;
use Statamic\Sites\Site;

class Email extends FormsEmail
{
    public SubmissionHelper $submissionHelper;

    public function __construct(Submission $submission, array $config, Site $site)
    {
        parent::__construct($submission, $config, $site);

        $this->submissionHelper = new SubmissionHelper($submission, $site, $config);
    }

    public function attachments(): array
    {
        return collect(config('statamic-formattach.forms'))
            ->filter(fn ($value, $key) => $key == $this->submissionHelper->form->handle())
            ->flatten()
            ->map(function (string $class) {
                return (new $class($this->submissionHelper))();
            })
            ->filter()
            ->toArray();
    }
}
