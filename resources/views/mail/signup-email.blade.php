Dobrý deň {{$email_data['name']}}
<br><br>
Pre dokončenie registrácie prosím kliknite na link nižšie, ak ste sa nikde neregistrovali tento email ignorujte.
<br><br>
<a href="{{ route('verify.user', $email_data['verification_code']) }}">Klikni tu!</a>