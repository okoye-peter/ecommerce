@component('mail::message')
# WELCOME MESSAGE

<p style="line-height: 2;">
welcome <strong>{{ $user->name }}</strong> to  the best online <br>
shopping platform, we have the best exciting offers for you. <br>
You are welcome <strong>{{ $user->name }}</strong> to explore <span style="font-size: 25px;">&#128526;</span> .....
</p>

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
