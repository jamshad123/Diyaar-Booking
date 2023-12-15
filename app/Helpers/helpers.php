<?php

if (! function_exists('systemDate')) {
    function systemDate($value)
    {
        if ($value) {
            return date('d-m-Y', strtotime($value));
        } else {
            return $value;
        }
    }
}
if (! function_exists('systemDateTime')) {
    function systemDateTime($value)
    {
        if ($value) {
            return date('d-m-Y h:i A', strtotime($value));
        } else {
            return $value;
        }
    }
}
if (! function_exists('systemTime')) {
    function systemTime($value)
    {
        if ($value) {
            return date('h:i A', strtotime($value));
        } else {
            return $value;
        }
    }
}
if (! function_exists('percentage')) {
    function percentage($value, $decimal_count = 2)
    {
        if($value) {
            return number_format($value, $decimal_count).'%';
        } else {
            return '0.00%';
        }
    }
}
if (! function_exists('currency')) {
    function currency($value, $decimal_count = 2)
    {
        if($value) {
            return number_format($value, $decimal_count);
        } else {
            return number_format(0, $decimal_count);
        }
    }
}
if (! function_exists('numberInteger')) {
    function numberInteger($value, $decimal_count = 2)
    {
        return number_format($value);
    }
}
if (! function_exists('ExcelDateConversion')) {
    function ExcelDateConversion($EXCEL_DATE)
    {
        $UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;

        return gmdate('Y-m-d', $UNIX_DATE);
    }
}
if (! function_exists('MonthCount')) {
    function MonthCount($date1, $date2)
    {
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);
        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);
        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);
        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

        return $diff;
    }
}
if (! function_exists('paymentModeOptions')) {
    function paymentModeOptions()
    {
        return [
            'Direct Payment' => 'Direct Payment',
            'Card' => 'Card',
            'STC Pay' => 'STC Pay',
        ];
    }
}
if (! function_exists('DocumentUpload')) {
    function DocumentUpload($file, $path)
    {
        $fileName = time().'.'.$file->extension();
        $disk = Storage::disk('public');
        if (! File::exists($path)) {
            File::makeDirectory($path, $mode = 777, true, true);
        }
        $disk->putFileAs($path, $file, $fileName);
        $uploaded_path = $disk->url($path.$fileName);

        return [
            'fileName' => $fileName,
            'uploaded_path' => $uploaded_path,
        ];
    }
}
if (! function_exists('FileUpload')) {
    function FileUpload($file, $target)
    {
        $disk = Storage::disk('public');
        if (! File::exists($target)) {
            File::makeDirectory($target, $mode = 755, true, true);
        }
        $filename = time().'-'.$file->getClientOriginalName();
        $source = $file->getRealPath();
        $with_folder_file_name = $target.$filename;
        $disk->putFileAs($with_folder_file_name, $file, $filename);
        $path = $disk->url($disk);

        return [
            'fileName' => $filename,
            'path' => $path,
        ];
    }
}
if (! function_exists('TableView')) {
    function TableView($data)
    {
        echo "<table border='1' style='color:white'>";
        echo '<thead>';
        if (isset($data[0])) {
            echo '<tr>';
            foreach ($data[0] as $key => $value) {
                echo "<td>$key</td>";
            }
            echo '</tr>';
        } else {
            foreach ($data as $key => $single) {
                echo '<tr>';
                foreach ($single as $key => $value) {
                    echo "<td>$key</td>";
                }
                echo '</tr>';
                break;
            }
        }
        echo '</thead>';
        echo '<tbody>';
        foreach ($data as $single) {
            echo '<tr>';
            foreach ((array) $single as $key => $value) {
                echo "<td align='right'>".$single[$key] ?? $single->key.'</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
}

if (! function_exists('purposeOfVisits')) {
    function purposeOfVisits()
    {
        return [
            'Tourism' => 'Tourism',
            'Family OF Friends' => 'Family OF Friends',
            'Hajju' => 'Hajju',
            'Umrah' => 'Umrah',
            'Religious' => 'Religious',
            'Business Or Work' => 'Business Or Work',
            'Sports' => 'Sports',
            'Entertainment' => 'Entertainment',
            'Other' => 'Other',
            'Work(Royal Court)' => 'Work(Royal Court)',
            'Quarantined Quests' => 'Quarantined Quests',
            'Ministry of Health Staff' => 'Ministry of Health Staff',
        ];
    }
}
if (! function_exists('genderOptions')) {
    function genderOptions()
    {
        return [
            'Male' => 'Male',
            'Female' => 'Female',
        ];
    }
}

if (! function_exists('activeAndDisabled')) {
    function activeAndDisabled()
    {
        return [
            'Active' => 'Active',
            'Disabled' => 'Disabled',
        ];
    }
}
if (! function_exists('documentTypeOptions')) {
    function documentTypeOptions()
    {
        return [
            'ID Card' => 'ID Card',
            'Passport' => 'Passport',
            'Residence Permit' => 'Residence Permit',
            'GCC ID' => 'GCC ID',
        ];
    }
}

if (! function_exists('customerTypeOptions')) {
    function customerTypeOptions()
    {
        return [
            'Citizen' => 'Citizen',
            'Foreigner' => 'Foreigner',
            'Gulf Citizen' => 'Gulf Citizen',
            'Visitor' => 'Visitor',
        ];
    }
}
if (! function_exists('convertToHijri')) {
    function convertToHijri($date)
    {
        return systemDate(\GeniusTS\HijriDate\Hijri::convertToHijri($date));
    }
}

if (! function_exists('percentageAmount')) {
    function percentageAmount($amount, $percentage)
    {
        return $amount * $percentage / 100;
    }
}
if (! function_exists('numberToWords')) {
    function numberToWords($number)
    {
        $ones = [
            0 => 'ZERO',
            1 => 'ONE',
            2 => 'TWO',
            3 => 'THREE',
            4 => 'FOUR',
            5 => 'FIVE',
            6 => 'SIX',
            7 => 'SEVEN',
            8 => 'EIGHT',
            9 => 'NINE',
            10 => 'TEN',
            11 => 'ELEVEN',
            12 => 'TWELVE',
            13 => 'THIRTEEN',
            14 => 'FOURTEEN',
            15 => 'FIFTEEN',
            16 => 'SIXTEEN',
            17 => 'SEVENTEEN',
            18 => 'EIGHTEEN',
            19 => 'NINETEEN',
            '014' => 'FOURTEEN',
        ];
        $tens = [
            0 => 'ZERO',
            1 => 'TEN',
            2 => 'TWENTY',
            3 => 'THIRTY',
            4 => 'FORTY',
            5 => 'FIFTY',
            6 => 'SIXTY',
            7 => 'SEVENTY',
            8 => 'EIGHTY',
            9 => 'NINETY',
        ];
        $hundreds = [
            'HUNDRED',
            'THOUSAND',
            'MILLION',
            'BILLION',
            'TRILLION',
            'QUARDRILLION',
        ]; /*limit t quadrillion */
        $number = number_format($number, 2, '.', ',');
        $number_arr = explode('.', $number);
        $wholenum = $number_arr[0];
        $decnum = $number_arr[1];
        $whole_arr = array_reverse(explode(',', $wholenum));
        krsort($whole_arr, 1);
        $rettxt = '';
        foreach($whole_arr as $key => $i) {

        while(substr($i, 0, 1) == '0')
                $i = substr($i, 1, 5);
        if($i < 20) {
        /* echo "getting:".$i; */
        $rettxt .= $ones[$i];
        }elseif($i < 100) {
        if(substr($i, 0, 1) != '0')  $rettxt .= $tens[substr($i, 0, 1)];
        if(substr($i, 1, 1) != '0') $rettxt .= ' '.$ones[substr($i, 1, 1)];
        }else {
        if(substr($i, 0, 1) != '0') $rettxt .= $ones[substr($i, 0, 1)].' '.$hundreds[0];
        if(substr($i, 1, 1) != '0')$rettxt .= ' '.$tens[substr($i, 1, 1)];
        if(substr($i, 2, 1) != '0')$rettxt .= ' '.$ones[substr($i, 2, 1)];
        }
        if($key > 0) {
        $rettxt .= ' '.$hundreds[$key].' ';
        }
        }
        if($decnum > 0) {
        $rettxt .= ' and ';
        if($decnum < 20) {
        $rettxt .= $ones[$decnum];
        }elseif($decnum < 100) {
        $rettxt .= $tens[substr($decnum, 0, 1)];
        $rettxt .= ' '.$ones[substr($decnum, 1, 1)];
        }
        }

        return $rettxt;
    }
}
