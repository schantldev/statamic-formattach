<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use SchantlDev\Statamic\FormAttach\Attachments\AttachPdf;
use SchantlDev\Statamic\FormAttach\Forms\SubmissionHelper;
use Statamic\Facades\FormSubmission;
use Statamic\Facades\Site;

if (! App::isProduction()) {
    Route::get('submissions/{submission_id}/preview', function (string $submission_id) {
        $submission = FormSubmission::find($submission_id);

        $preview = new AttachPdf(new SubmissionHelper($submission, Site::default(), []));

        return response($preview->view(preview: true), 200);
    })->name('statamic-formattach-preview');

    Route::get('submissions/{submission_id}/preview_pdf', function (string $submission_id) {
        $submission = FormSubmission::find($submission_id);

        $preview = new AttachPdf(new SubmissionHelper($submission, Site::default(), []));

        return response($preview->pdf(), 200, ['Content-Type' => 'application/pdf']);
    })->name('statamic-formattach-preview-pdf');
}
