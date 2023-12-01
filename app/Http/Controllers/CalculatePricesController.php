<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;


class CalculatePricesController extends Controller
{
    function calculatePrices($start_date, $end_date)
    {
        $items = collect([
            ['start_date' => '15-1-2022', 'end_date' => '22-1-2022', 'price' => 7],
            ['start_date' => '3-1-2022', 'end_date' => '12-1-2022', 'price' => 3],
            ['start_date' => '4-1-2022', 'end_date' => '11-1-2022', 'price' => 10],
            ['start_date' => '1-1-2022', 'end_date' => '19-1-2022', 'price' => 5],
        ]);

        // Order ascending prices.
        $items = $items->sortBy('price');

        // Declare an empty array
        $searchPeriod = array();

        // Star date
        $realStart = new DateTime($start_date);

        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');

        // End date
        $realEnd = new DateTime($end_date);
        $realEnd->add($interval);

        // Get all days in the search period.
        $period = new DatePeriod($realStart, $interval, $realEnd);

        // Use loop to store date into array
        foreach ($period as $date) {
            $searchPeriod[] = $date->format('Y-m-d');
        }

        $final_price = 0;

        // Use loop to days in the search period.
        foreach ($searchPeriod as $day) {

            // Use a loop for items stored.
            foreach ($items as $item) {

                // Convert the Start and end date to the same format.
                $startDatePeriod = date('Y-m-d', strtotime($item['start_date']));
                $endDatePeriod = date('Y-m-d', strtotime($item['end_date']));

                // Check if day-in-range prices must not be calculated.
                if ($day >= $startDatePeriod && $day <= $endDatePeriod) {

                    // If true add the price to the final price
                    $final_price += $item['price'];

                    // Stop second loop
                    break 1;
                }
            }
        }

        return $final_price;
    }
}
