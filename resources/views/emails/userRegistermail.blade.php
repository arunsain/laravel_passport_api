@component('mail::message')
# Introduction
<b>Here is ur Code</b>
<br>


<br>
code : <b>{{ $data['randomCode'] }}</b>

<br>

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
