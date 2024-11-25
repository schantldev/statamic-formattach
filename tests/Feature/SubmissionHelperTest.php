<?php

use SchantlDev\Statamic\FormAttach\Forms\SubmissionHelper;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Form;
use Statamic\Facades\Site;

test('it augments a submission for a view', function () {
    $submission = Form::make('test')->makeSubmission();

    $blueprint = Blueprint::makeFromFields([
        'foo' => [
            'type' => 'text',
        ],
        'bar' => [
            'type' => 'checkboxes',
            'options' => [
                'uno' => 'One',
                'dos' => 'Two',
                'tres' => 'Three',
            ],
        ],
    ]);
    Blueprint::shouldReceive('find')->with('forms.test')->andReturn($blueprint);

    $submission->data(['foo' => 'Test value of a string.', 'bar' => ['dos', 'tres']]);

    $submission_helper = new SubmissionHelper($submission, Site::default(), []);

    expect($submission_helper->data())
        ->toBeArray()
        ->toHaveKeys(['now', 'today', 'fields']);

    expect($submission_helper->data()['fields']->pluck('value'))
        ->count()->toBe(2)
        ->collect()->each->toBeInstanceOf(Statamic\Fields\Value::class);
});
