@component('mail::message')

Dear %recipient.name%,

{{ $user->name }} has been joined our community as a {{ $user->sports->first()->name }} player.

@component('mail::button', ['url' => config('app.api_url') . '/' . $user->username ])
Check Profile
@endcomponent

Best Regards,<br>
{{ config('app.name') }} Team
@endcomponent
