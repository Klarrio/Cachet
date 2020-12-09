@component('mail::message')
# {{ trans('notifications.incident.new.mail.greeting', ['app_name' => Config::get('setting.app_name')]) }}

{{ $incident->message }}

@component('mail::button', ['url' => $actionUrl])
{{ $actionText }}
@endcomponent

Regards, Team DSH
@include('notifications.partials.logo')

@include('notifications.partials.subscription')

@endcomponent
