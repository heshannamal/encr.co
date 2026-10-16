<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Organization;
use Carbon\Carbon;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateStudioItemBillingOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'studio_item_order:create_billing_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            Log::info('Studio item billing order command started');

            $orderItems = OrderItem::where('is_studio_item', 1)
                                        ->where('is_billed', 0)
                                        ->where('active', 1)
                                        ->where('order_status_id', 4)
                                        ->get();
            $orderItemSubTotal = $orderItems->sum('total');

            if(count($orderItems) > 0){
                Log::info('Studio item billing order Start Prossecing');

                $contact = OrdersCommenFacade::getStudioContact();
                // $orgnization = Organization::find(1377); // Encore Inventory

                $maxId = Order::max('id');
                $orderNo = str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);

                $newOrder = new Order();
                $newOrder->organization_id = 1377;
                $newOrder->contact_id = $contact->id;
                $newOrder->order_no = $orderNo;
                $newOrder->order_status_id = 4; // Fulfilled
                $newOrder->user_id = 1;
                $newOrder->order_procesing_user_id = 1;
                $newOrder->sub_total = $orderItemSubTotal;
                // $newOrder->sales_tax = $request->sales_tax;
                // $newOrder->shipping = $request->shipping;
                // $newOrder->order_description = $request->order_description;
                // $newOrder->artwork = $request->artwork;
                // $newOrder->processing_fee = $request->processing_fee;
                // $newOrder->order_total = $request->order_total;
                $newOrder->open_date = Carbon::now()->format('m/d/Y');
                // $newOrder->encore_packing_date = $request->encore_packing_date;
                $newOrder->due_date = Carbon::now()->format('m/d/Y');
                $newOrder->ex_factory_date = Carbon::now()->format('m/d/Y');
                $newOrder->active = 1;

                $newOrder->ex_factory_date = Carbon::now()->format('m/d/Y');

                $newOrder->est_delivery_date = Carbon::now()->format('m/d/Y');

                $newOrder->is_new_shipping_address = 0;
                $newOrder->street = $contact->shipping_street;
                $newOrder->city = $contact->shipping_city;
                $newOrder->state = $contact->shipping_state;
                $newOrder->postal_code = $contact->shipping_zip;
                $newOrder->country = $contact->shipping_country;
                $newOrder->phone_no = $contact->phone_no;
                $newOrder->email = $contact->email;

                $newOrder->is_studio_item_order = 1;

                $newOrder->save();

                foreach ($orderItems as $orderItem) {
                    $itemOrderId = $orderItem->order_id;
                    $orderItem->parent_order_id = $itemOrderId;
                    $orderItem->order_id = $newOrder->id;
                    $orderItem->is_billed = 1;
                    $orderItem->update();
                }

                OrdersCommenFacade::create_invoice_by_factory_confirmation($newOrder->id);

                Log::info("Studio item billing order created successfully.");
            }
            Log::info("Studio item billing order command ended.");
        } catch(Exception $e) {
            Log::error("Error creating studio item billing order: " . $e->getMessage());
        }
    }
}
