<?php

return [

    /**
     * The logo used for the standard PDF attachment.
     *
     * Specify a path to some image file.
     * Example: public_path('resources/img/attachment_logo.png')
     */
    'logo' => null,

    /**
     * The paper format used to generate the PDF.
     *
     * Specify any format that is supported by Browsershot.
     *
     * @see https://spatie.be/docs/browsershot/v4/usage/creating-pdfs#content-using-a-predefined-format
     */
    'format' => 'A4',

    /**
     * The sizes table you can use within the view to
     * support a browser based preview.
     * Sizes are defined as [width, height]
     */
    'format_sizes' => [
        'Letter' => ['8.5in', '11in'],
        'Legal' => ['8.5in', '14in'],
        'Tabloid' => ['11in', '17in'],
        'Ledger' => ['17in', '11in'],
        'A0' => ['841mm', '1189mm'],
        'A1' => ['594mm', '841mm'],
        'A2' => ['420mm', '594mm'],
        'A3' => ['297mm', '420mm'],
        'A4' => ['210mm', '297mm'],
        'A5' => ['148mm', '210mm'],
        'A6' => ['105mm', '148mm'],
    ],

    /**
     * The margins applied to PDF pages.
     */
    'margins' => [
        'top' => 10,
        'right' => 15,
        'bottom' => 15,
        'left' => 10,
        'unit' => 'mm',
    ],

    'forms' => [
        'form_handle' => [
            // \SchantlDev\Statamic\FormAttach\Attachments\AttachPdf::class,
        ],
    ],
];
