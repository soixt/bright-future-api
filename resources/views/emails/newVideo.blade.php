@component('mail::message')

Dear %recipient.name%,

{{ $user->name }} has been added a new {{ $user->videos->last()->type }} video.

@component('mail::button', ['url' => config('app.api_url') . '/' . $user->username ])
Check It
@endcomponent

Best Regards,<br>
{{ config('app.name') }} Team
@endcomponent
