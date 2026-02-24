<?php

namespace app\Others;

use app\Validators\Validator;
use app\Exceptions\ValidationException;
use DateTime;


class Date{

    private DateTime $actualDate;
    public function __construct(){
        $this->actualDate = new DateTime;
    }

    public function setDateRange($range): string
    {

        switch ($range) {
            case VALID_TIME_RANGES[0]:
                $this->actualDate->modify("-1 day");
                break;
            case VALID_TIME_RANGES[1]:
                $this->actualDate->modify("-1 week");
                break;
            case VALID_TIME_RANGES[2]:
                $this->actualDate->modify("-1 month");
                break;
            case VALID_TIME_RANGES[3]:
                $this->actualDate->modify("-1 year");
                break;
        }

        return $this->actualDate->format("Y-m-d");

    }
}