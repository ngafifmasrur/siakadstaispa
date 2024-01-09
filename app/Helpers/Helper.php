<?php

if (!function_exists('numToRoman')) {
    /**
     * Returns a numeric conversion to roman
     *
     * @return string
     *
     * */
    function numToRoman($num,$isUpper=true) {
        $n = intval($num);
        $res = '';

        $roman_numerals = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        );

        foreach ($roman_numerals as $roman => $number)
        {
            $matches = intval($n / $number);

            $res .= str_repeat($roman, $matches);

            $n = $n % $number;
        }

        if($isUpper) return $res;
        else return strtolower($res);
    }
}

if (!function_exists('numToText')) {
    /**
     * Returns a numeric to text
     *
     * @return string
     *
     * */
    function numToTextConversion($x){

        $x = abs($x);
        $angka = array ("","satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";

        if($x < 12){
            $temp = " ".$angka[$x];
        }else if($x<20){
            $temp = numToTextConversion($x - 10)." belas";
        }else if ($x<100){
            $temp = numToTextConversion($x/10)." puluh". numToTextConversion($x%10);
        }else if($x<200){
            $temp = " seratus".numToTextConversion($x-100);
        }else if($x<1000){
            $temp = numToTextConversion($x/100)." ratus".numToTextConversion($x%100);
        }else if($x<2000){
            $temp = " seribu".numToTextConversion($x-1000);
        }else if($x<1000000){
            $temp = numToTextConversion($x/1000)." ribu".numToTextConversion($x%1000);
        }else if($x<1000000000){
            $temp = numToTextConversion($x/1000000)." juta".numToTextConversion($x%1000000);
        }else if($x<1000000000000){
            $temp = numToTextConversion($x/1000000000)." milyar".numToTextConversion($x%1000000000);
        }

        return $temp;
    }

    function numToTextDec($x){
        $str = stristr($x,",");
        $ex = explode(',',$x);

        if(($ex[1]/10) >= 1){
            $a = abs($ex[1]);
        } else {
            $a = 0;
        }
        $string = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan",   "sembilan","sepuluh", "sebelas");
        $temp = "";

        $a2 = $ex[1]/10;
        $pjg = strlen($str);
        $i =1;


        if($a>=1 && $a< 12){
            $temp .= " ".$string[$a];
        }else if($a>12 && $a < 20){
            $temp .= numToTextConversion($a - 10)." belas";
        }else if ($a>20 && $a<100){
            $temp .= numToTextConversion($a / 10)." puluh". numToTextConversion($a % 10);
        }else{
            if($a2<1){

                while ($i<$pjg){
                    $char = substr($str,$i,1);
                    $i++;
                    $temp .= " ".$string[$char];
                }
            }
        }
        return $temp;
    }

    function numToText($x){
        if($x<0){
            $hasil = "minus ".trim(numToTextConversion(x));
        }else{
            $poin = (strpos($x, ',') !== false)
                 ? ' koma '. trim(numToTextDec($x))
                 : '';
            $hasil = trim(numToTextConversion($x)) ?: 'nol';
        }

        return $hasil.$poin;
    }

    if (! function_exists('numToRupiah')) {
        /**
         * Fungsi untuk memformat number menjadi format indonesia
         *
         * @param integer $number
         * @return string
         */
        function numToRupiah($number)
        {
            if (! $number) {
                return 0;
            }

            return 'Rp '. number_format($number, 0, ',', '.');
        }
    }
}
