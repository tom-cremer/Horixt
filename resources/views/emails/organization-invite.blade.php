<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>You're invited to join {{ $organization->name }}</title>
</head>
<body style="margin:0; padding:30px; background-color:#f9f9f9; font-family: 'Lexend', 'Poppins', Helvetica, Arial, sans-serif; color: #333333;">

<table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width:620px; margin:0 auto; background-color:#ffffff; border:1px solid #e0e0e0;">
    <tr>
        <td style="padding:40px;">

            <!-- Logo and Title -->
            <table width="100%" cellpadding="0" cellspacing="0" style="text-align:center; margin-bottom:30px;">
                <tr>
                    <td>
                        <!-- Inline SVG is not recommended in emails, consider using an image instead -->
                        <span style="font-size:32px; font-weight:bold; color:#4F46E5; vertical-align:middle;">{{ config('app.name') }}</span>
                    </td>
                </tr>
            </table>

            <!-- Title -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:15px;">
                <tr>
                    <td style="font-size:24px; font-weight:bold; text-align:center;">
                        You're invited to join {{ $organization->name }}
                    </td>
                </tr>
            </table>

            <!-- Message Content -->
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="font-size:16px; line-height:1.6; padding-bottom:15px;">
                        Holà,
                    </td>
                </tr>
                <tr>
                    <td style="font-size:16px; line-height:1.6; padding-bottom:15px;">
                        <b>{{ $user->name }}</b> has invited you to join the organization <b>{{ $organization->name }}</b> on Horixt.
                    </td>
                </tr>
                <tr>
                    <td style="font-size:16px; line-height:1.6; padding-bottom:15px;">
                        To accept the invitation and join the team, simply click the button below:
                    </td>
                </tr>

                <!-- Button -->
                <tr>
                    <td align="center" style="padding:24px 0;">
                        <a href="{{route('organization-invite', ['token' => $token])}}" style="background-color:#4F46E5; color:#ffffff; text-decoration:none; padding:14px 28px; font-size:16px; font-weight:bold; border-radius:4px; display:inline-block;">
                            Accept Invitation
                        </a>
                    </td>
                </tr>

                <tr>
                    <td style="font-size:16px; line-height:1.6; padding-bottom:15px;">
                        If you do not wish to join, you can safely ignore this email.
                    </td>
                </tr>
            </table>

            <!-- Footer -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:50px;">
                <tr>
                    <td style="font-size:14px; text-align:center; color:#777777;">
                        — The Horixt Team
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>

</body>
</html>
