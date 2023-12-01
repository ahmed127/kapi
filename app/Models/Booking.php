<?php

namespace App\Models;

use App\Models\Price;


class Booking
{
    public $prices = [];

    public function addPrice($startDate, $endDate, $price)
    {
        $newPrice = new Price($startDate, $endDate, $price);
        $this->prices[] = $newPrice;
    }

    public function getPrice($start_date, $end_date)
    {
        $selectedPrice = null;

        foreach ($this->prices as $price) {
            if ($start_date >= $price->startDate && $end_date <= $price->endDate) {
                $selectedPrice = $price->price;
                break;
            }
        }

        return $selectedPrice;
    }
}
