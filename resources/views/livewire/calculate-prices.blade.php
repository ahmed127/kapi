<div class="row m-5 bg-dark-subtle">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="card mx-auto">
            <div class="card-header">
                <h5 class="card-title">Prices Example 2</h5>
                <p class="card-subtitle mb-2 text-muted">
                    prices in the following order.
                </p>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $key => $item)
                        <tr>
                            <td>{{ $item['start_date'] }}</td>
                            <td>{{ $item['end_date'] }}</td>
                            <td>{{ $item['price'] }}</td>
                            <td><button class="btn btn-sm btn-danger" wire:click="delItem({{ $key }})">Del</button></td>
                        </tr>

                        @empty

                        @endforelse

                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <input class="form-control" type="date" wire:model="item_start_date">
                                @error('item_start_date')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <input class="form-control" type="date" wire:model="item_end_date">
                                @error('item_end_date')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <input class="form-control" type="number" wire:model="item_price">
                                @error('item_price')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </td>
                            <td><button class="btn btn-sm btn-success" wire:click="addItem">Add</button></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Calculate Prices</h5>
                <p class="card-subtitle mb-3 text-muted">
                    Calculate Prices between start and end date
                </p>
            </div>
            <div class="card-body my-2">
                <div class="row gap-3">
                    <div class="col-12">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" wire:model.live="start_date">
                        @error('start_date')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" wire:model.live="end_date">
                        @error('end_date')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12 my-auto">
                        <button type="submit" class="btn btn-primary" wire:click="calculatePrices">Submit</button>
                    </div>
                </div>
                <div class="my-4">
                    Final Price : {{ $final_price??0 }}
                </div>
            </div>
        </div>
    </div>
</div>
