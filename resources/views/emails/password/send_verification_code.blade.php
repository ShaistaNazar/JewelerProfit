@component('mail::message')
# Password Verification Code

@component('mail::panel')
Your Password Verification Code is<br><br>
<span style="padding:5px;background-color:white;color:black">{{$code}}</span>
<span>this will expire after using it for once</span>
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
