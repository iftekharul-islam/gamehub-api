@extends('new_email.layout')
@section('content')
    <tr>
        <td style="padding-left: 80px; ">
            Dear concern,
        </td>
    </tr>
    <tr>
        <td style="padding-left: 80px; padding-right: 80px">
            <p>You've recently asked to reset the password for your GameHub account.</p>
            <p>To update your password, Reset code is {{ $otp }}</p>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 80px; ">
            <p style="margin-top: 40px; margin-bottom: 8px;">Cheers,</p> <b>The GameHub</b>
        </td>
    </tr>
@endsection




