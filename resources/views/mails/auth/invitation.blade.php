<x-mail::message>
Hello,

You have been invited to join {{ $tenant_name }}

To accept the invitation, click on the button below and create an account.

<x-mail::button :url="$acceptUrl">
    Join Tenant
</x-mail::button>

If you did not expect to receive an invitation to this tenant, you may disregard this email.

Thanks,
{{ config('app.name') }}
</x-mail::message>
