<?php

namespace domainencore\Services\OrdersCommenService;

use App\Models\Contact;
use App\Models\ExFactory;
use App\Models\FactoryInvoice;
use App\Models\InvoiceProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Organization;
use App\Models\Price;

class OrdersCommenService
{
    protected $organization;
    protected $ex_factory;
    protected $contact;

    public function __construct()
    {
        $this->organization = new Organization();
        $this->ex_factory = new ExFactory();
        $this->contact = new Contact();
    }

    public function getEncoreOrgIds()
    {
        return $this->organization->where('organization_name', 'LIKE', '%Encore%')->get()->pluck('id');
    }

    public function getStudioExfacotry(){
        $studioExfactory = $this->ex_factory->where('ex_factory_name', 'Studio - Sri Lanka')->where('active', 1)->first();
        if($studioExfactory){
            return $studioExfactory;
        } else {
            $newStudioExfactory = new ExFactory();
            $newStudioExfactory->ex_factory_name = 'Studio - Sri Lanka';
            $newStudioExfactory->city = 'Colombo';
            $newStudioExfactory->state = 'Western';
            $newStudioExfactory->country = 'Sri Lanka';
            $newStudioExfactory->active = 1;
            $newStudioExfactory->created_by = auth()->user()->id;
            $newStudioExfactory->save();
            return $newStudioExfactory;
        }
        return false;
    }

    public function getStudioContact()
    {
        $contact = $this->contact->where('first_name', 'Studio')->where('last_name', 'Sri Lanka')->where('active', 1)->first();
        if($contact){
            return $contact;
        } else {
            $newContact = $this->contact;
            $newContact->first_name = 'Studio';
            $newContact->last_name = 'Sri Lanka';
            $newContact->organization_id = 1377;
            $newContact->lead_source = 'Self Generated';
            $newContact->phone_no = '0778816299';
            $newContact->email = 'prasad@encorebrand.com';
            $newContact->user_id = 1;
            $newContact->shipping_city = 'Colombo';
            $newContact->shipping_state = 'Western';
            $newContact->shipping_country = 'Sri Lanka';
            $newContact->active = 1;
            $newContact->save();
            return $newContact;
        }
        return false;
    }

    public function create_invoice_by_factory_confirmation($order_id)
    {

        // Do not create factory invoice for Test Organization
        // Test Organization ID = 2890
        $isTestOrganization = Order::where('id', $order_id)
            ->where('organization_id', 2890)
            ->exists();

        if ($isTestOrganization) {
            return;
        }
        $isExist = FactoryInvoice::where('order_id', $order_id)->where('active', 1)->exists();

        if (!$isExist) {
            $maxId = FactoryInvoice::max('id');
            $invoice_no = 'INV' . str_pad(($maxId + 1), 4, "0", STR_PAD_LEFT);

            $invoice = new FactoryInvoice();
            $invoice->invoice_number = $invoice_no;
            $invoice->order_id = $order_id;
            $invoice->total_amount = 0;
            $invoice->sub_total = 0;
            $invoice->reduce_value = 0;
            $invoice->status = 0;
            $invoice->save();

            $invoiceId = $invoice->id;

            $order_items = OrderItem::where('factory_id', 1)->where('active', 1)->where('order_id', $order_id)->get();

            $sum = 0.00;

            foreach ($order_items as $order_item) {
                $manufacture = Price::where('price_type', '5')->where('active', 1)->where('product_id', $order_item->product_id)->first();
                $manufacture_price = $manufacture ? $manufacture->price : 0.00;
                InvoiceProduct::create([
                    'invoice_id' => $invoiceId,
                    'product_id' => $order_item->product_id,
                    'qty' => $order_item->qty,
                    'order_item_id' => $order_item->id,
                    'unit_price' => $manufacture_price,
                    'total_price' => ($manufacture_price * $order_item->qty),
                ]);

                $sum += ($manufacture_price * $order_item->qty);
            }

            $saved_invoice = FactoryInvoice::find($invoiceId);
            $saved_invoice->total_amount = number_format($sum, 2, '.', '');
            $saved_invoice->sub_total = number_format($sum, 2, '.', '');
            $saved_invoice->save();
        }
    }
}
