<div class="col-md-12">
    <form action="{{ route('inventory_orders.add_to_inventory') }}" method="POST" id="inventory_detail_form">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-field">
                    <label class="form-lable" for="order_flag">Order #</label>
                    <input type="text" class="form-control" id="order_number" value="{{ $order->order_no }}" readonly>
                    <input type="hidden" id="order_id" name="order_id" value="{{ $order->id }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-field">
                    <label class="form-lable" for="order_flag">Inventory Type</label>
                    <select class="form-control select2-inventory-type" name="inventory_type_id" id="inventory_type_id" required>
                        <option value="">Select an Inventory Type</option>
                        <option @if(isset($inventory) && $inventory->inventory_type_id == 1) selected @endif value="1">Sample</option>
                        <option @if(isset($inventory) && $inventory->inventory_type_id == 2) selected @endif value="2">Encore Custome</option>
                        <option @if(isset($inventory) && $inventory->inventory_type_id == 3) selected @endif value="3">Encore Lacrose</option>
                        {{-- @foreach($orders as $order)
                            <option value="{{$order->id}}">{{$order->order_no}}</option>
                        @endforeach --}}
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Qty</th>
                            <th class="text-right">Unit Price ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $orderItem)
                            <tr>
                                <td>{{ $orderItem->subProduct->product_name ?? '' }}</td>
                                <td></td>
                                <td></td>
                                <td>{{ $orderItem->qty }}</td>
                                <td class="text-right">{{ number_format($orderItem->unit_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if (isset($inventory))
            @if ($inventory->status == 1)
                <div class="row">
                    <div class="col-md-12 text-center">
                        <span class="badge badge-success">Order is sent to the Inventory by {{ $inventory->sentBy->name ?? '' }}</span>
                    </div>
                </div>
            @elseif ($inventory->status == 2)
                <div class="row">
                    <div class="col-md-12 text-center">
                        <span class="badge badge-default">This Order is added in the Inventory</span>
                    </div>
                </div>
            @elseif ($inventory->status == 3)
                <div class="row">
                    <div class="col-md-12 text-center">
                        <span class="badge badge-danger">This Order is rejected by the Inventory</span>
                    </div>
                </div>
            @endif
        @endif
        <div class="row">
            <div class="col-lg-12 control-btns mt-3">
                @if (isset($inventory))
                    @if ($inventory->status == 1)
                        <button type="button" class="btn btn-outline-danger btn-custom cancel-add-inventory" value="{{ $inventory->id }}">Cancel Adding to Inventory</button>
                    @elseif ($inventory->status == 0 || $inventory->status == 3 )
                        <button type="submit" class="btn btn-success btn-custom">Add to Inventory</button>
                    @endif
                @else
                    <button type="submit" class="btn btn-success btn-custom">Add to Inventory</button>
                @endif

                <button type="reset" class="btn btn-secondary btn-custom" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
</div>

