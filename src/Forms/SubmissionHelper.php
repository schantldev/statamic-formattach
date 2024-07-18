<?php

namespace SchantlDev\Statamic\FormAttach\Forms;

use Illuminate\Support\Collection;
use Statamic\Facades\Antlers;
use Statamic\Fields\Blueprint;
use Statamic\Forms\Form;
use Statamic\Forms\Submission;
use Statamic\Sites\Site;

class SubmissionHelper
{
    public ?Blueprint $blueprint;

    public ?Form $form;

    public Collection $data;

    public function __construct(
        public Submission $submission,
        public Site $site,
        public array $config,
        array $data = []
    ) {
        $this->form = $this->submission->form();
        $this->blueprint = $this->form->blueprint();
        $this->data = collect($data);
    }

    public function data(): array
    {
        return $this->submission->data()->toArray();
    }

    public function put(string $key, mixed $value): void
    {
        $this->data->put($key, $value);
    }

    public function get(string $key): mixed
    {
        return $this->data->get($key);
    }

    public function blueprintFields(): Collection
    {
        return $this->blueprint->fields()->items()->mapWithKeys(function ($field) {
            return [$field['handle'] => [
                'display' => $field['field']['display'] ?? 'Undefined name',
                'width' => $field['field']['width'] ?? 100,
            ]];
        });
    }

    public function subject(): string
    {
        return Antlers::parse(__($this->config['subject'] ?? 'Attachment'), $this->data());
    }
}
