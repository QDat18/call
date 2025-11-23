@component('mail::message')
# Hello,

You have received a new message from **{{ $organizationName }}**.

---

### {{ $messageContent }}

---

Thanks,<br>
{{ config('app.name') }}
@endcomponent