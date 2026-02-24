<?php

namespace app\Validators;


Class Validator {

    public function validTimeRange(string $time_range):bool{
        return in_array($time_range,VALID_TIME_RANGES);
    }

    public function validLimit($limit):bool{
        return ($limit > 0 && $limit <=20);
    }

}