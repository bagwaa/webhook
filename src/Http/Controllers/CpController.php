<?php

declare(strict_types=1);

namespace Bagwaa\Webhook\Http\Controllers;

use Illuminate\Contracts\View\View;

class CpController
{
    public function index(): View
    {
        return view('webhook::index');
    }

    public function update(): void
    {
        // Handle the form submission
    }
}
