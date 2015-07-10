<?php

namespace Nuxeo\Model;

/**
 * Contains Utilities such as date wrappers
 */
class NuxeoUtilities {
    private $ini;

    public function dateConverterPhpToNuxeo($date) {
        return date_format($date, 'Y-m-d');
    }

    public function dateConverterNuxeoToPhp($date) {
        $newDate = explode('T', $date);
        $phpDate = new DateTime($newDate[0]);
        return $phpDate;
    }

    public function dateConverterInputToPhp($date) {

        $edate = explode('/', $date);
        $day = $edate[2];
        $month = $edate[1];
        $year = $edate[0];

        if ($month > 0 AND $month < 12)
            if ($month % 2 == 0)
                if ($day < 1 OR $day > 31) {
                    echo 'date not correct';
                    exit;
                }
                elseif ($month == 2)
                    if (year % 4 == 0)
                        if ($day > 29 OR $day < 0) {
                            echo 'date not correct';
                            exit;
                        }
                        else
                            if ($day > 28 OR $day < 0) {
                                echo 'date not correct';
                                exit;
                            }
                            else
                                if ($day > 30 OR $day < 0) {
                                    echo 'date not correct';
                                    exit;
                                }

        $phpDate = new DateTime($year . '-' . $month . '-' . $day);

        return $phpDate;
    }

}
