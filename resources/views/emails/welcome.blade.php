@component('mail::message')
# Introduction

Dear %recipient.name%,
{{ $user->name }}
Whats up?

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
