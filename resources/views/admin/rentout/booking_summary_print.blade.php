<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Summary</title>
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
                        <h2 style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 22px">Booking Summary
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
                    <td style="text-align: left; font-size: 14px; font-family: Arial, Helvetica, sans-serif; color: #000000; padding:0 15px; width: 30%; border: 1px solid #f1f1f1;">
                        <p style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">Booking Number:
                            <b>{{ $self['booking_no'] }}</b>
                        </p>
                        <p style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">VAT Registration No:
                            <b>{{ $vat_registration_no }}</b>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width: 1000px; margin: 0 auto; font-family: Arial, Helvetica, sans-serif; color: #000000; border: 1px solid #f1f1f1; margin-bottom: 15px;">
            <thead>
                <tr>
                    <th colspan="2" style="border: 1px solid #f1f1f1;">
                        <h3 style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 16px;"> Contract</h3>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="left" valign="middle" nowrap="nowrap" style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Check In Date</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ systemDate($self['check_in_date']) }} ({{ date('l',strtotime($self['check_in_date'])) }})</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Check Out Date</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ systemDate($self['check_out_date']) }} ({{ date('l',strtotime($self['check_out_date'])) }})</b>
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
                                        Equals</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ convertToHijri($self['check_in_date']) }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Equals</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ convertToHijri($self['check_out_date']) }}</b>
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
                                        Actual Check In Date</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>12/12/2022</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Actual Check Out Date</td>
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
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Equals</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>18/05/1444</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Equals</td>
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
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Time</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ systemTime($self['check_in_date']) }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Time</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ systemTime($self['check_out_date']) }}</b>
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
                                        Booking Type</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>Daily</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        No Of Room(s) </td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ $self->rentoutRooms()->count() }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="5%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Room
                                    </td>
                                    <td width="95%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>
                                            <?php foreach ($self->rentoutRooms as $key => $value): ?>
                                            @if($key),@endif {{ $value->room->room_no }}
                                            <?php endforeach; ?>
                                        </b>
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
                                        Days</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ $self->days() }}</b>
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
                                        Peak Price</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>0</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Peak Days</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>0</b>
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
                                        Total</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ currency($self['total']) }} SAR</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Discount</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ currency($self['discount_amount']) }} SAR</b>
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
                                        Net Amount</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ currency($self['grand_total']) }} SAR</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Tax</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ currency($self['tax']) }} SAR</b>
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
                                        Received Amount</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ currency($self['advance_amount']) }} SAR</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Security Deposite</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ currency($self['security_amount']) }} SAR</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width: 1000px; margin: 0 auto; font-family: Arial, Helvetica, sans-serif; color: #000000; border: 1px solid #f1f1f1; margin-bottom: 15px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #f1f1f1;" colspan="2">
                        <h3 style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 16px">
                            Customer
                        </h3>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="left" valign="middle" nowrap="nowrap" style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Customer Name</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ $self->customer->full_name }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Nationality</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ $self->customer->country }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle" nowrap="nowrap" style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <?php $documentType = $self->customer->documentType() ?>
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Document Type
                                    </td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ $documentType['title'] }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                @foreach($documentType['field'] as $key => $value)
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        {{ $key }}
                                    </td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ $value }}</b>
                                    </td>
                                </tr>
                                @endforeach
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
                                        Date</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ systemDate($self['created_at']) }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Agent</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ $self->agent->full_name??'' }}</b>
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
                                        Mobile</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b>{{ $self->customer->mobile }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; border: 1px solid #f1f1f1; padding:0 15px;" align="left" valign="middle">
                        <table width="100%" border="0" cellpadding="0" cellspacing="10">
                            <tbody>
                                <tr>
                                    <td width="40%" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        Dependents</td>
                                    <td width="5%">:</td>
                                    <td width="55%" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
                                        <b> - </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width: 1000px; margin: 0 auto; font-family: Arial, Helvetica, sans-serif; color: #000000; border: 1px solid #f1f1f1; margin-bottom: 15px;">
            <thead>
                <tr>
                    <th align="center" valign="middle" nowrap="nowrap" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 16px; padding: 15px; border: 1px solid #f1f1f1;">
                        Operation
                    </th>
                    <th align="center" valign="middle" nowrap="nowrap" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 16px; padding: 15px; border: 1px solid #f1f1f1;">
                        Voucher Number
                    </th>
                    <th align="center" valign="middle" nowrap="nowrap" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 16px; padding: 15px; border: 1px solid #f1f1f1;">
                        Date</th>
                    <th align="center" valign="middle" nowrap="nowrap" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 16px; padding: 15px; border: 1px solid #f1f1f1;">
                        Creditor
                    </th>
                    <th align="center" valign="middle" nowrap="nowrap" style="font-weight: 700; font-family: Arial, Helvetica, sans-serif; font-size: 16px; padding: 15px; border: 1px solid #f1f1f1;">
                        Debitor
                    </th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                @foreach($journals as $journal)
                <tr>
                    <td align="center" valign="middle" nowrap="nowrap" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;padding: 15px; border: 1px solid #f1f1f1;">
                        {{ $journal['operation'] }}
                    </td>
                    <td align="center" valign="middle" nowrap="nowrap" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;padding: 15px; border: 1px solid #f1f1f1;">
                        {{ $journal['voucher_number'] }}
                    </td>
                    <td align="center" valign="middle" nowrap="nowrap" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;padding: 15px; border: 1px solid #f1f1f1;">
                        {{ systemDate($journal['date']) }}
                    </td>
                    <td align="center" valign="middle" nowrap="nowrap" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;padding: 15px; border: 1px solid #f1f1f1;">
                        @if($journal['credit']) {{ currency($journal['credit']) }} + @else --- @endif
                    </td>
                    <td align="center" valign="middle" nowrap="nowrap" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px;padding: 15px; border: 1px solid #f1f1f1;">
                        @if($journal['debit']) {{ currency($journal['debit']) }} - @else --- @endif
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td align="center" valign="middle" nowrap="nowrap" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px; padding: 15px; border: 1px solid #f1f1f1;">
                    </td>
                    <td colspan="2" align="center" valign="middle" nowrap="nowrap" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px; padding: 15px; border: 1px solid #f1f1f1;">
                    </td>
                    <td align="center" valign="middle" nowrap="nowrap" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px; padding: 15px; border: 1px solid #f1f1f1;">
                        <?php $credit = array_sum(array_column($journals, 'credit')) ?>
                        {{ currency($credit) }}
                    </td>
                    <td align="center" valign="middle" nowrap="nowrap" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px; padding: 15px; border: 1px solid #f1f1f1;">
                        <?php $debit = array_sum(array_column($journals, 'debit')) ?>
                        {{ currency($debit) }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width: 1000px; margin: 0 auto; font-family: Arial, Helvetica, sans-serif; color: #000000; border: 1px solid #f1f1f1;">
            <tfoot>
                <tr>
                    <td align="left" valign="middle" nowrap="nowrap" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px; padding: 15px;">
                        ﺳﻌﯾد ﻣﺣﻣد ﻣﻛﻲ
                    </td>
                    <td align="right" valign="middle" nowrap="nowrap" style="font-weight: 400; font-family: Arial, Helvetica, sans-serif; font-size: 14px; padding: 15px;">
                        Balance: <b>{{ currency($debit - $credit) }}</b>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
<script type="text/javascript">
    'use strict';
    (function () { window.print(); })();
</script>

</html>