@component('mail::message')
#Forget password

    Forget code : {{ $forget_code }}
    <hr/>
    URL: {{ $url }}
@endcomponent
