<?php

namespace App\Models;

use DateTime;
use Exception;

class Price
{

    /** @var array $prices Array to store the prices and their corresponding start and end dates. */
    private $prices = [];

    /**
     * Add a new price with its start and end dates.
     *
     * @param string $start_date The start date of the price in the format "d/m/Y".
     * @param string $end_date The end date of the price in the format "d/m/Y".
     * @param float $price The price per day.
     *
     * @throws Exception If the start date is after the end date.
     */
    public function addPrice($start_date, $end_date, $price)
    {
        // Convert the start and end dates to DateTime objects
        $start_date = DateTime::createFromFormat('d/m/Y', $start_date);
        $end_date = DateTime::createFromFormat('d/m/Y', $end_date);

        // Check if the start date is after the end date
        if ($start_date > $end_date) {
            throw new Exception("Start date cannot be after end date.");
        }

        // Add the price to the prices array
        $this->prices[] = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'price' => $price
        ];
    }

    /**
     * Get the price for a given date.
     *
     * @param string $date The date for which to get the price in the format "d/m/Y".
     *
     * @return float The price for the given date.
     */
    public function getPrice($date)
    {
        // Convert the date to a DateTime object
        $date = DateTime::createFromFormat('d/m/Y', $date);

        // Iterate through the prices array and find the first price that covers the given date
        foreach ($this->prices as $price) {
            if ($date >= $price['start_date'] && $date <= $price['end_date']) {
                return $price['price'];
            }
        }

        // If no price is found, return the price of the first older price
        if (!empty($this->prices)) {
            return $this->prices[0]['price'];
        }

        // If no prices are added, return 0 as the default price
        return 0;
    }
}

