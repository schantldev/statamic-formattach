<?php

use Illuminate\Support\Facades\Route;

test('routes are available in non production env', function () {
    expect($this->app->isProduction())->toBeFalse();

    expect(Route::has('statamic-formattach-preview'))->toBeTrue();
    expect(Route::has('statamic-formattach-preview-pdf'))->toBeTrue();
});
