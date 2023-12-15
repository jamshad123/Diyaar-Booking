<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Voucher</title>
    <style>
        body {
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="main-wrapper" style="background-color: #f3f3f3; padding: 30px; margin: 0">
        <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width: 1000px; margin: 0 auto; font-family: Arial, Helvetica, sans-serif; color: #000000; border: 1px solid #f1f1f1; margin-bottom: 15px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #f1f1f1;" colspan="2">
                        <h2 style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 22px">Receipt Voucher
                        </h2>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr style="border: 1px solid #f1f1f1;">
                    <td nowrap="nowrap" style="text-align: left; font-size: 14px; font-family: Arial, Helvetica, sans-serif; color: #000000; padding:0 15px; width: 30%; border: 1px solid #f1f1f1;">
                        <p style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">Date:
                            <b>{{ systemDateTime($self['created_at']) }}</b>
                        </p>
                        <p>Equals: <b>{{ convertToHijri($self['created_at']) }}</b></p>
                    </td>
                    <td style="text-align: right; font-size: 14px; font-family: Arial, Helvetica, sans-serif; color: #000000; padding:0 15px; width: 30%; border: 1px solid #f1f1f1;">
                        <p style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                            Voucher Number: <b> {{ $self['id'] }}</b>
                        </p>
                        <p style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                            Booking Number: <b>{{ $self->checkout->rentout->booking_no }}</b>
                        </p>
                    </td>
                </tr>
                <tr style="border: 1px solid #f1f1f1;">
                    <td nowrap="nowrap" style="text-align: center; font-size: 14px; font-family: Arial, Helvetica, sans-serif; color: #000000; padding:0 15px; width: 30%; border: 1px solid #f1f1f1;" colspan="2">
                        <p style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                            VAT Registration No: {{ $vat_registration_no }}
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width: 1000px; margin: 0 auto; font-family: Arial, Helvetica, sans-serif; color: #000000; border: 1px solid #f1f1f1; margin-bottom: 15px;">
            <tbody>
                <tr>
                    <td align="left" valign="middle" nowrap="nowrap" style="border: 1px solid #f1f1f1; padding:0 15px;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Received From Mr./Mis.</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ $self->checkout->customer->full_name }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle" nowrap="nowrap" style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Amount.</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ currency($self->amount) }} ({{ numberToWords($self->amount) }}) SAR </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle" nowrap="nowrap" style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Payment type
                                    </td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ $self->payment_mode }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        And This For </td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>Room Checkout Payment</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle" nowrap="nowrap" style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Comments</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>---</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle" nowrap="nowrap" style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="35%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align: center;">
                                        Receiver Name<br><br>
                                        {{ $self->createdBy->name }}
                                    </td>
                                    <td width="30%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align: center;">
                                        Cashier
                                        <br><br>
                                        ---------------------
                                    </td>
                                    <td width="35%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align: center;">
                                        Manager
                                        <br><br>
                                        ---------------------
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
<script type="text/javascript">
    'use strict';
    (function () { window.print(); })();
</script>

</html>