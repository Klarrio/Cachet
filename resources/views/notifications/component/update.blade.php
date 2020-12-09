@component('mail::message')
# {{ trans('notifications.component.status_update.mail.greeting') }}

{{ $content }}

Regards, Team DSH
@include('notifications.partials.logo')

@include('notifications.partials.subscription')

@endcomponent
