# Statamic FormAttach

> Statamic FormAttach is a Statamic addon that allows to easily attach any files to form submission mails dynamically.

## Features

This addon provides:

- A standard PDF attachment for form submissions[^1]
- Support for any other attachment(s) you might need to add dynamically

## How to Install

Install the addon using composer.

```bash
composer require schantldev/statamic-formattach
```

Publish the configuration file.

```bash
php artisan vendor:publish --tag=statamic-formattach-config
```

Swap out the send email job in your `statamic/forms.php` config file.

```php
/*
|--------------------------------------------------------------------------
| Send Email Job
|--------------------------------------------------------------------------
|
| The class name of the job that will be used to send an email.
|
*/

'send_email_job' => \SchantlDev\Statamic\FormAttach\Forms\SendEmailWithAttachments::class,
```

## How to Use

After publishing the config file, you will be able to add attachments to any forms you wish. There's an array with the form handle and attachments to possibly be added.

```php
'forms' => [
    'form_handle' => [
        // \SchantlDev\Statamic\FormAttach\Attachments\AttachPdf::class,
    ],
],
```

### Attaching PDFs

There is a default attachment that will generate a PDF using Spatie's Browsershot package[^1]. In the config, you can find more settings for choosing a paper size and setting a custom logo. If that's not enough, you can opt in to publish the view[^3] and adjust it to your needs or create your own custom attachment.

```bash
php artisan vendor:publish --tag=statamic-formattach-views
```

> [!TIP]
> If you wanna see a live preview while working on the view, there's a way! There are two routes you can use for your already saved submission:
>
> 1. as HTML: submissions/{submission_id}/preview
> 2. as PDF: submissions/{submission_id}/preview_pdf

### Custom attachments

Sometimes, PDFs are just not enough or you need some more fine-grained control over the attachment. In that case, you can extend the `FormAttachment` class and implement its abstract method to provide any attachment in form of a mailable attachment[^2].

```php
use Illuminate\Mail\Mailables\Attachment;

abstract class FormAttachment {
    ...
    public function check(): bool;
    abstract public function attachment(): ?Attachment;
}
```

### Controlling whether to add an attachment

In the above excerpt, you can see a `check()` method that is present within a FormAttachment class. Use it to decide on whether to add an attachment or not. You can use the [SubmissionHelper](src/Forms/SubmissionHelper.php) object that gives you access to the submission data, the form, the blueprint of the form and the config of the mail.

**Example: (only attach PDF to owner mail - in a [Statamic Peak](https://github.com/studio1902/statamic-peak) context)**

```php
namespace App\FormAttachments;

use SchantlDev\Statamic\FormAttach\Attachments\AttachPdf;

class PdfAttachment extends AttachPdf
{
    public function check(): bool
    {
        return $this->submissionHelper->config['html'] == 'email/form_owner';
    }
}
```

## Contributing and Issues

Contributions and discussions are always welcome, no matter how large or small. If you happen to find an issue, please open up a Github issue or do a PR if you can.

[^1]: The addon requires Browserhot for the PDF attachment to work out of the box. Please note that the addon will not install Browsershot for you as you might have already installed some version of it. Please install Browsershot directly into your project.
[^2]: Refer to the offical [Laravel documentation](https://laravel.com/docs/mail#attachments) on how to create attachments in various ways.
