@component('mail::message')

Dear coach %recipient.name%,

{{ config('app.name') }} is an online service that connects athletes and coaches.

Today, we present you {{ $user->age }} years old {{ $user->name }}, from {{ $user->extended->location }}.

@component('mail::button', ['url' => config('app.api_url') . '/' . $user->username ])
Watch Highlights
@endcomponent

If you consider offering {{ $user->extended->gender == 'male' ? 'him' : 'her' }} a scholarship, you can contact {{ $user->extended->gender == 'male' ? 'him' : 'her' }} directly at <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>.

You can also join our community and make your own list of favorite athletes, with email notifications when they add a new video and/or when the new athletes join.

@component('mail::button', ['url' => config('app.api_url')])
Join Now
@endcomponent

If you don't want to receive emails from us anymore, please click <a href="{{ config('app.api_url') }}/app/stop-emails/%recipient.hash%">here</a>.

Best Regards,<br>
{{ config('app.name') }} Team
@endcomponent
