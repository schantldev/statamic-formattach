<?php

namespace SchantlDev\Statamic\FormAttach\Forms;

use Illuminate\Support\Collection;
use Statamic\Facades\Antlers;
use Statamic\Facades\Config;
use Statamic\Facades\GlobalSet;
use Statamic\Fields\Blueprint;
use Statamic\Forms\Form;
use Statamic\Forms\Submission;
use Statamic\Sites\Site;
use Statamic\Support\Arr;

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

    public function put(string $key, mixed $value): void
    {
        $this->data->put($key, $value);
    }

    public function get(string $key): mixed
    {
        return $this->data->get($key);
    }

    public function data(): array
    {
        $augmented = $this->submission->toAugmentedArray();
        $fields = $this->getRenderableFieldData(Arr::except($augmented, ['id', 'date', 'form']));

        if (Arr::has($this->config, 'attachments')) {
            $fields = $fields->reject(fn ($field) => in_array($field['fieldtype'], ['assets', 'files']));
        }

        $data = array_merge($augmented, $this->getGlobalsData(), [
            'config' => config()->all(),
            'fields' => $fields,
            'site_url' => Config::getSiteUrl(),
            'date' => now(),
            'now' => now(),
            'today' => now(),
            'site' => $this->site->handle(),
            'locale' => $this->site->handle(),
        ]);

        return array_merge($data, $this->data->toArray());
    }

    private function getRenderableFieldData($values)
    {
        return collect($values)->map(function ($value, $handle) {
            $field = $value->field();
            $display = $field->display();
            $fieldtype = $field->type();
            $config = $field->config();

            return compact('display', 'handle', 'fieldtype', 'config', 'value');
        })->values();
    }

    private function getGlobalsData()
    {
        $data = [];

        foreach (GlobalSet::all() as $global) {
            if (! $global->existsIn($this->site->handle())) {
                continue;
            }

            $global = $global->in($this->site->handle());

            $data[$global->handle()] = $global->toAugmentedArray();
        }

        return $data;
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
