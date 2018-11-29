<?php

class Number_towords {

    function __construct() {
        $this->CI = & get_instance();
    }

    /*
      function convert_number_to_words($number) {

      $hyphen = ' ';
      $conjunction = '  ';
      $separator = ' ';
      $negative = 'Negative ';
      $decimal = ' point ';
      $dictionary = array(
      0 => 'Zero',
      1 => 'One',
      2 => 'Two',
      3 => 'Three',
      4 => 'Four',
      5 => 'Five',
      6 => 'Six',
      7 => 'Seven',
      8 => 'Eight',
      9 => 'Nine',
      10 => 'Ten',
      11 => 'Eleven',
      12 => 'Twelve',
      13 => 'Thirteen',
      14 => 'Fourteen',
      15 => 'Fifteen',
      16 => 'Sixteen',
      17 => 'Seventeen',
      18 => 'Eighteen',
      19 => 'Nineteen',
      20 => 'Twenty',
      30 => 'Thirty',
      40 => 'Fourty',
      50 => 'Fifty',
      60 => 'Sixty',
      70 => 'Seventy',
      80 => 'Eighty',
      90 => 'Ninety',
      100 => 'Hundred',
      1000 => 'Thousand',
      1000000 => 'Million',
      1000000000 => 'Billion',
      1000000000000 => 'Trillion',
      1000000000000000 => 'Quadrillion',
      1000000000000000000 => 'Quintillion'
      );

      if (!is_numeric($number)) {
      return false;
      }

      if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
      // overflow
      trigger_error(
      '$this->convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
      );
      return false;
      }

      if ($number < 0) {
      return $negative . $this->convert_number_to_words(abs($number));
      }

      $string = $fraction = null;

      if (strpos($number, '.') !== false) {
      list($number, $fraction) = explode('.', $number);

      }

      switch (true) {
      case $number < 21:
      $string = $dictionary[$number];
      break;
      case $number < 100:
      $tens = ((int) ($number / 10)) * 10;
      $units = $number % 10;
      $string = $dictionary[$tens];
      if ($units) {
      $string .= $hyphen . $dictionary[$units];
      }
      break;
      case $number < 1000:
      $hundreds = $number / 100;
      $remainder = $number % 100;
      $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
      if ($remainder) {
      $string .= $conjunction . $this->convert_number_to_words($remainder);
      }
      break;
      default:
      $baseUnit = pow(1000, floor(log($number, 1000)));
      $numBaseUnits = (int) ($number / $baseUnit);
      $remainder = $number % $baseUnit;
      $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
      if ($remainder) {
      $string .= $remainder < 100 ? $conjunction : $separator;
      $string .= $this->convert_number_to_words($remainder);
      }
      break;
      }

      if (null !== $fraction && is_numeric($fraction)) {
      $string .= $decimal;
      $words = array();
      foreach (str_split((string) $fraction) as $number) {
      $words[] = $dictionary[$number];
      }

      $string .= implode(' ', $words);
      //$string .= $this->convert_number_to_words($fraction);
      }

      return $string;
      }
     * 
     * 
	 *
     */

    function convert_number_to_words($number, $isfrac=false) {
        list($integer, $fraction) = explode(".", (string) $number);

        $output = "";

        if ($integer{0} == "-") {
            $output = "Negative ";
            $integer = ltrim($integer, "-");
        } else if ($integer{0} == "+") {
            $output = "Positive ";
            $integer = ltrim($integer, "+");
        }

        if ($integer{0} == "0") {
            $output .= "Zero";
        } else {
            $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
            $group = rtrim(chunk_split($integer, 3, " "), " ");
            $groups = explode(" ", $group);

            $groups2 = array();
            foreach ($groups as $g) {
                $groups2[] = $this->convertThreeDigit($g{0}, $g{1}, $g{2});
            }

            for ($z = 0; $z < count($groups2); $z++) {
                if ($groups2[$z] != "") {
                    $output .= $groups2[$z] . $this->convertGroup(11 - $z) . (
                            $z < 11 && !array_search('', array_slice($groups2, $z + 1, -1)) && $groups2[11] != '' && $groups[11]{0} == '0' ? " and " : ", "
                            );
                }
            }

            $output = rtrim($output, ", ");
        }
        
        if($isfrac==false)
        {
            $output.=" Dollars";
        }
        
        if ($fraction > 0) {
            //$output .= " point ";
            $output .= " and ";
            /*for ($i = 0; $i < strlen($fraction); $i++) {
                $output .= " " . $this->convertDigit($fraction{$i});
            }*/
            $output.=$this->convert_number_to_words($fraction, true);
            $output.=" Cents";
        }
        
        return $output;
    }

    function convertGroup($index) {
        switch ($index) {
            case 11:
                return " Decillion";
            case 10:
                return " Nonillion";
            case 9:
                return " Octillion";
            case 8:
                return " Septillion";
            case 7:
                return " Sextillion";
            case 6:
                return " Quintrillion";
            case 5:
                return " Quadrillion";
            case 4:
                return " trillion";
            case 3:
                return " Billion";
            case 2:
                return " Million";
            case 1:
                return " Thousand";
            case 0:
                return "";
        }
    }

    function convertThreeDigit($digit1, $digit2, $digit3) {
        $buffer = "";

        if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0") {
            return "";
        }

        if ($digit1 != "0") {
            $buffer .= $this->convertDigit($digit1) . " Hundred";
            if ($digit2 != "0" || $digit3 != "0") {
                $buffer .= " and ";
            }
        }

        if ($digit2 != "0") {
            $buffer .= $this->convertTwoDigit($digit2, $digit3);
        } else if ($digit3 != "0") {
            $buffer .= $this->convertDigit($digit3);
        }

        return $buffer;
    }

    function convertTwoDigit($digit1, $digit2) {
        if ($digit2 == "0") {
            switch ($digit1) {
                case "1":
                    return "Ten";
                case "2":
                    return "Twenty";
                case "3":
                    return "Thirty";
                case "4":
                    return "Forty";
                case "5":
                    return "Fifty";
                case "6":
                    return "Sixty";
                case "7":
                    return "Seventy";
                case "8":
                    return "Eighty";
                case "9":
                    return "Ninety";
            }
        } else if ($digit1 == "1") {
            switch ($digit2) {
                case "1":
                    return "Eleven";
                case "2":
                    return "Twelve";
                case "3":
                    return "Thirteen";
                case "4":
                    return "Fourteen";
                case "5":
                    return "Fifteen";
                case "6":
                    return "Sixteen";
                case "7":
                    return "Seventeen";
                case "8":
                    return "Eighteen";
                case "9":
                    return "Nineteen";
            }
        } else {
            $temp = $this->convertDigit($digit2);
            switch ($digit1) {
                case "2":
                    return "Twenty-$temp";
                case "3":
                    return "Thirty-$temp";
                case "4":
                    return "Forty-$temp";
                case "5":
                    return "Fifty-$temp";
                case "6":
                    return "Sixty-$temp";
                case "7":
                    return "Seventy-$temp";
                case "8":
                    return "Eighty-$temp";
                case "9":
                    return "Ninety-$temp";
            }
        }
    }

    function convertDigit($digit) {
        switch ($digit) {
            case "0":
                return "Zero";
            case "1":
                return "One";
            case "2":
                return "Two";
            case "3":
                return "Three";
            case "4":
                return "Four";
            case "5":
                return "Five";
            case "6":
                return "Six";
            case "7":
                return "Seven";
            case "8":
                return "Eight";
            case "9":
                return "Nine";
        }
    }

}
