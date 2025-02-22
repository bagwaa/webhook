@extends('statamic::layout')

@section('content')
    <form method="POST" action="{{ cp_route('bagwaa-webhook.save') }}">
        @csrf

        <div class="card p-4">
            <h1 class="text-lg font-bold mb-4">Webhook Addon Settings</h1>

            <div class="mb-4">
                <label for="example_setting" class="block text-sm font-medium">Webhook URL</label>
                <input type="text" name="webhook_url" id="webhook_url" value="{{ $settings['webhook_url'] ?? '' }}" class="input-text mt-1 w-full">
            </div>

            <button type="submit" class="btn-primary">Save</button>
        </div>
    </form>
@endsection
