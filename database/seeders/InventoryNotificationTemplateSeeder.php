<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InventoryNotificationTemplateSeeder extends Seeder
{
    /**
     * Seed notification templates for inventory order accept/reject events
     * triggered from the Encorecustom_ecomerce system.
     */
    public function run(): void
    {
        $columns = Schema::getColumnListing('notification_templates');
        $now = now();

        $templates = [
            [
                'template_key'      => 'key_inventory_order_accepted_by_inventory',
                'name'              => 'Inventory Order Accepted by Inventory',
                'function_name'     => 'systemAccept',
                'controller'        => 'InventoryOrderController',
                'title'             => 'Inventory Order #{order_no} Accepted by Inventory',
                'modal_title'       => 'Inventory Order #{order_no} Accepted',
                'notification_body' => '<p>Inventory order <strong>#{order_no}</strong> has been <strong>accepted</strong> and added to <strong>{inventory_type}</strong> stock by <strong>{responded_by}</strong> (Inventory Order #{inventory_order_no}).</p>',
                'description'       => 'Triggered when an inventory order sent from Encore Cloud is accepted in the Ecommerce/Inventory system. Placeholders: {order_no}, {inventory_order_no}, {inventory_type}, {responded_by}, {organization_name}',
                'proccessing_rep'   => 1,
                'sales_rep'         => 1,
                'related_fac'       => 0,
                'status'            => 1,
            ],
            [
                'template_key'      => 'key_inventory_order_rejected_by_inventory',
                'name'              => 'Inventory Order Rejected by Inventory',
                'function_name'     => 'systemReject',
                'controller'        => 'InventoryOrderController',
                'title'             => 'Inventory Order #{order_no} Rejected by Inventory',
                'modal_title'       => 'Inventory Order #{order_no} Rejected',
                'notification_body' => '<p>Inventory order <strong>#{order_no}</strong> for <strong>{inventory_type}</strong> has been <strong>rejected</strong> by <strong>{responded_by}</strong>.</p><p><strong>Reason:</strong> {reason}</p>',
                'description'       => 'Triggered when an inventory order sent from Encore Cloud is rejected in the Ecommerce/Inventory system. Placeholders: {order_no}, {inventory_type}, {responded_by}, {reason}, {organization_name}',
                'proccessing_rep'   => 1,
                'sales_rep'         => 1,
                'related_fac'       => 0,
                'status'            => 1,
            ],
        ];

        foreach ($templates as $tpl) {
            $exists = DB::table('notification_templates')
                ->where('template_key', $tpl['template_key'])
                ->exists();

            if ($exists) {
                continue;
            }

            $payload = array_intersect_key($tpl, array_flip($columns));
            if (in_array('created_at', $columns, true)) {
                $payload['created_at'] = $now;
            }
            if (in_array('updated_at', $columns, true)) {
                $payload['updated_at'] = $now;
            }

            DB::table('notification_templates')->insert($payload);
        }

        $this->seedEmailTemplates();
    }

    /**
     * Seed email notification templates in encore_main.email_notifications for
     * inventory order accept/reject events from Encorecustom_ecomerce.
     */
    protected function seedEmailTemplates(): void
    {
        if (!Schema::hasTable('email_notifications')) {
            return;
        }

        $columns = Schema::getColumnListing('email_notifications');
        $now = now();

        $emailTemplates = [
            [
                'template_key'    => 'key_email_inv_order_accepted',
                'name'            => 'Inventory Order Accepted by Inventory',
                'function_name'   => 'systemAccept',
                'controller'      => 'InventoryOrderController',
                'subject'         => 'Inventory Order #{{ $orderNo }} Accepted by Inventory',
                'body'            => <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Order Accepted</title>
</head>
<body style="margin:0; padding:0; background-color:#f8fafc; font-family:Arial, Helvetica, sans-serif; color:#1e293b;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f8fafc; padding:32px 12px;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="max-width:600px; background-color:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #e2e8f0;">
                    <tr>
                        <td style="background-color:#0f766e; padding:22px 28px; color:#ffffff;">
                            <h2 style="margin:0; font-size:18px; font-weight:700;">Inventory Order Accepted</h2>
                            <p style="margin:6px 0 0; font-size:13px; color:#ccfbf1;">Order #{{ $orderNo }} has been added to inventory stock</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:26px 28px; font-size:14px; line-height:1.6;">
                            <p style="margin-top:0;">Hello,</p>
                            <p>The inventory order sent from <strong>Encore Cloud</strong> has been <strong>accepted</strong> and added to stock in the Inventory system.</p>
                            <table border="0" cellpadding="8" cellspacing="0" width="100%" style="background-color:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; margin:18px 0; font-size:13.5px;">
                                <tr>
                                    <td width="42%" style="color:#64748b; font-weight:600;">Order Number</td>
                                    <td style="color:#0f172a; font-weight:700;">#{{ $orderNo }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#64748b; font-weight:600; border-top:1px solid #e2e8f0;">Inventory Order #</td>
                                    <td style="color:#0f172a; border-top:1px solid #e2e8f0;">#{{ $inventoryOrderNo }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#64748b; font-weight:600; border-top:1px solid #e2e8f0;">Organization</td>
                                    <td style="color:#0f172a; border-top:1px solid #e2e8f0;">{{ $organizationName }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#64748b; font-weight:600; border-top:1px solid #e2e8f0;">Inventory Type</td>
                                    <td style="color:#0f172a; border-top:1px solid #e2e8f0;">{{ $inventoryType }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#64748b; font-weight:600; border-top:1px solid #e2e8f0;">Accepted By</td>
                                    <td style="color:#0f172a; border-top:1px solid #e2e8f0;">{{ $respondedBy }}</td>
                                </tr>
                            </table>
                            <p style="margin-bottom:0; color:#64748b; font-size:12.5px;">This is an automated notification from Encore Inventory.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML,
                'description'     => 'Sent to Encore Cloud users when a sent inventory order is accepted. Variables: $orderNo, $inventoryOrderNo, $organizationName, $inventoryType, $respondedBy',
                'proccessing_rep' => 1,
                'sales_rep'       => 1,
                'related_fac'     => 0,
                'order_customer'  => 0,
                'active'          => 1,
            ],
            [
                'template_key'    => 'key_email_inv_order_rejected',
                'name'            => 'Inventory Order Rejected by Inventory',
                'function_name'   => 'systemReject',
                'controller'      => 'InventoryOrderController',
                'subject'         => 'Inventory Order #{{ $orderNo }} Rejected by Inventory',
                'body'            => <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Order Rejected</title>
</head>
<body style="margin:0; padding:0; background-color:#f8fafc; font-family:Arial, Helvetica, sans-serif; color:#1e293b;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f8fafc; padding:32px 12px;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="max-width:600px; background-color:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #e2e8f0;">
                    <tr>
                        <td style="background-color:#b91c1c; padding:22px 28px; color:#ffffff;">
                            <h2 style="margin:0; font-size:18px; font-weight:700;">Inventory Order Rejected</h2>
                            <p style="margin:6px 0 0; font-size:13px; color:#fee2e2;">Action may be required for Order #{{ $orderNo }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:26px 28px; font-size:14px; line-height:1.6;">
                            <p style="margin-top:0;">Hello,</p>
                            <p>The inventory order sent from <strong>Encore Cloud</strong> has been <strong>rejected</strong> in the Inventory system.</p>
                            <table border="0" cellpadding="8" cellspacing="0" width="100%" style="background-color:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; margin:18px 0; font-size:13.5px;">
                                <tr>
                                    <td width="42%" style="color:#64748b; font-weight:600;">Order Number</td>
                                    <td style="color:#0f172a; font-weight:700;">#{{ $orderNo }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#64748b; font-weight:600; border-top:1px solid #e2e8f0;">Organization</td>
                                    <td style="color:#0f172a; border-top:1px solid #e2e8f0;">{{ $organizationName }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#64748b; font-weight:600; border-top:1px solid #e2e8f0;">Inventory Type</td>
                                    <td style="color:#0f172a; border-top:1px solid #e2e8f0;">{{ $inventoryType }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#64748b; font-weight:600; border-top:1px solid #e2e8f0;">Rejected By</td>
                                    <td style="color:#0f172a; border-top:1px solid #e2e8f0;">{{ $respondedBy }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#64748b; font-weight:600; border-top:1px solid #e2e8f0;">Reason</td>
                                    <td style="color:#b91c1c; font-weight:600; border-top:1px solid #e2e8f0;">{{ $reason }}</td>
                                </tr>
                            </table>
                            <p style="margin-bottom:0; color:#64748b; font-size:12.5px;">Please review this order in Encore Cloud and re-send to inventory if needed.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML,
                'description'     => 'Sent to Encore Cloud users when a sent inventory order is rejected. Variables: $orderNo, $organizationName, $inventoryType, $respondedBy, $reason',
                'proccessing_rep' => 1,
                'sales_rep'       => 1,
                'related_fac'     => 0,
                'order_customer'  => 0,
                'active'          => 1,
            ],
        ];

        foreach ($emailTemplates as $tpl) {
            $exists = DB::table('email_notifications')
                ->where('template_key', $tpl['template_key'])
                ->exists();

            if ($exists) {
                continue;
            }

            $payload = array_intersect_key($tpl, array_flip($columns));
            if (in_array('created_at', $columns, true)) {
                $payload['created_at'] = $now;
            }
            if (in_array('updated_at', $columns, true)) {
                $payload['updated_at'] = $now;
            }

            DB::table('email_notifications')->insert($payload);
        }
    }
}
