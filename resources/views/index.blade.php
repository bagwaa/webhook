@extends('statamic::layout')

@section('content')
    <div>
        <publish-form
            title="Webhook"
            action="{{ cp_route('bagwaa-webhook.update') }}"
        ></publish-form>
    </div>
@endsection
