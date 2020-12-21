@component('mail::message')
# {{ trans('notifications.schedule.new.mail.title') }}

{{ $content }}

Regards, Team DSH
@include('notifications.partials.logo')
@include('notifications.partials.subscription')

@endcomponent
