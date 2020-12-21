@component('mail::message')
# {{ trans('notifications.incident.update.mail.title', ['name' => $incidentName, 'new_status' => $newStatus])  }}

{{ $update->message }}

@component('mail::button', ['url' => $actionUrl])
{{ $actionText }}
@endcomponent

Regards, Team DSH
@include('notifications.partials.logo')

@include('notifications.partials.subscription')

@endcomponent
