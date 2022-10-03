<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Nric implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_string($value)) {
            return FALSE;
        }
        if (strlen($value) != 9) {
            return FALSE;
        }

        $characters = str_split($value);
        $weight = 0;
        $weight += (int)$characters[1] * 2;
        $weight += (int)$characters[2] * 7;
        $weight += (int)$characters[3] * 6;
        $weight += (int)$characters[4] * 5;
        $weight += (int)$characters[5] * 4;
        $weight += (int)$characters[6] * 3;
        $weight += (int)$characters[7] * 2;

        if ($characters[0] == "T" || $characters[0] == "G") {
            $weight += 4;
        }

        if ($characters[0] == "M") {
            $weight += 3;
        }

        $temp = $weight % 11;
        // If firstchar is M, rotate the index
        if ($characters[0] === 'M') {
            $temp = 10 - $temp;
        }

        $st = array("J", "Z", "I", "H", "G", "F", "E", "D", "C", "B", "A");
        $fg = array("X", "W", "U", "T", "R", "Q", "P", "N", "M", "L", "K");
        $m = array('K', 'L', 'J', 'N', 'P', 'Q', 'R', 'T', 'U', 'W', 'X');

        $theAlpha = '';
        if ($characters[0] == "S" || $characters[0] == "T") {
            $theAlpha = $st[$temp];
        } elseif ($characters[0] == "F" || $characters[0] == "G") {
            $theAlpha = $fg[$temp];
        } elseif ($characters[0] == "M") {
            $theAlpha = $m[$temp];
        }

        if ($characters[8] == $theAlpha) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute is incorrect';
    }
}
