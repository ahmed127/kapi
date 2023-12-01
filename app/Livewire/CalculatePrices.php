<?php

namespace App\Livewire;

use Livewire\Component;

use DateTime;
use DatePeriod;
use DateInterval;

class CalculatePrices extends Component
{
    public $items;
    public $start_date;
    public $end_date;
    public $final_price;
    public $item_start_date;
    public $item_end_date;
    public $item_price;

    public function mount()
    {
        $this->start_date = '2022-01-01';
        $this->end_date = '2022-01-13';
        $list_items = [
            ['start_date' => '15-1-2022', 'end_date' => '22-1-2022', 'price' => 7],
            ['start_date' => '3-1-2022', 'end_date' => '12-1-2022', 'price' => 3],
            ['start_date' => '4-1-2022', 'end_date' => '11-1-2022', 'price' => 10],
            ['start_date' => '1-1-2022', 'end_date' => '19-1-2022', 'price' => 5],
        ];
        $this->order_prices_ascending($list_items);
    }

    public function render()
    {
        return view('livewire.calculate-prices');
    }

    public function order_prices_ascending($list_items)
    {
        // Order ascending prices.
        $list = collect($list_items);
        $list->sortBy('price');

        $this->items = (array) $list->all();
    }

    public function calculatePrices()
    {
        $this->validate([
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after:start_date'
        ]);
        // Declare an empty array
        $searchPeriod = array();

        // Star date
        $realStart = new DateTime($this->start_date);

        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');

        // End date
        $realEnd = new DateTime($this->end_date);
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
            foreach ($this->items as $item) {

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

        return $this->final_price = $final_price;
    }

    public function addItem()
    {
        $this->validate([
            'item_start_date'   => 'required|date',
            'item_end_date'     => 'required|date|after:item_start_date',
            'item_price'        => 'required|numeric',
        ]);
        array_push($this->items, [
            'start_date'    => date('d-m-Y', strtotime($this->item_start_date)),
            'end_date'      => date('d-m-Y', strtotime($this->item_end_date)),
            'price'         => $this->item_price,
        ]);
        $this->order_prices_ascending($this->items);
    }

    public function delItem($key)
    {
        $list = collect($this->items);
        $list->sortBy('price');
        $list->forget($key);
        $this->items = (array) $list->all();
        $this->order_prices_ascending($this->items);
    }
}
