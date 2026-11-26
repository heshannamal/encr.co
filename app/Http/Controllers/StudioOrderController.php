<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FashionModel;
use App\Models\FashionModelImage;
use App\Models\FashionModelPhotoshootPhoto;
use App\Models\Kit;
use App\Models\OrderItem;
use App\Models\OrderItemFile;
use App\Models\Organization;
use App\Models\PmInbox;
use App\Models\PmSection;
use App\Models\PmSectionDiscussion;
use App\Models\PmSectionDiscussionComment;
use App\Models\PmSectionSubDiscussion;
use App\Models\PmTaskAssignee;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\Role;
use App\Models\Shoot;
use App\Models\ShootPersonItem;
use App\Models\StudioSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudioOrderController extends Controller
{
    public function index()
    {
        $data = OrderItem::with('subProduct', 'product', 'product.productCategories')
            ->where('is_studio_item', 1)
            ->orderByDesc('id')
            ->get();
 
       
        $itemOrganizationIds = $data->pluck('organization_id')->filter()->unique()->values();
        $organizationData = Organization::where('active', 1)
            ->orWhereIn('id', $itemOrganizationIds)
            ->orderBy('organization_name')
            ->get(['id', 'organization_name']);
 
      
        $categoryIds = $data->map(function ($item) {
                return $item->product ? $item->product->productCategories->pluck('product_category_id') : collect();
            })
            ->flatten()->filter()->unique()->values();
 
        $productCategoryData = ProductCategory::whereIn('id', $categoryIds)
            ->orderBy('product_category_name')
            ->get(['id', 'product_category_name']);
 
        // TECH PACKS: order_item_files rows of these items, in ONE query
        $techPackRows = OrderItemFile::whereIn('order_item_id', $data->pluck('id'))
            ->get(['id', 'order_item_id', 'tech_pack_images', 'tech_pack_image_name'])
            ->groupBy('order_item_id');
 
        // Fast lookups (no extra queries inside the loop)
        $organizationNames = $organizationData->pluck('organization_name', 'id');
        $categoryNames     = $productCategoryData->pluck('product_category_name', 'id');
 
        // CHAT: comment count of each item's sub discussion, in ONE query
        $chatCounts = $this->itemChatCounts($data->pluck('id')->all());
 
        $studioItems = $data->map(function ($item) use ($organizationNames, $categoryNames, $techPackRows, $chatCounts) {
            $subProduct = $item->subProduct;
            $product    = $item->product;
 
            // IMAGE: sub product mockup_img_1 -> product mockup_img_1
            $imagePath = $subProduct->mockup_img_1 ?? null;
            if (empty($imagePath)) {
                $imagePath = $product->mockup_img_1 ?? null;
            }
 
            // NAME: order item display_name -> sub product product_name -> product product_name
            $name = $item->display_name;
            if (empty($name)) {
                $name = $subProduct->product_name ?? null;
            }
            if (empty($name)) {
                $name = $product->product_name ?? '';
            }
 
            // PRODUCT STYLES: category ids from product_category_lists
            $styleIds = $product
                ? $product->productCategories->pluck('product_category_id')->filter()->map(fn ($id) => (int) $id)->unique()->values()->all()
                : [];
            $styleNames = array_values(array_filter(array_map(fn ($id) => $categoryNames[$id] ?? null, $styleIds)));
 
            return [
                'id'              => $item->id,
                'image'           => $this->imageUrl($imagePath),
                'name'            => $name,
                'styles'          => $styleIds,     
                'style_names'     => $styleNames,  
                'created_date'    => $item->created_at,  
                'exp_date'        => $this->parseDate($item->ex_factory_date),
                'chat_count'      => $chatCounts[$item->id] ?? 0,
                'order_id'        => $item->order_id,
                'order_number'    => str_pad((string) $item->order_id, 6, '0', STR_PAD_LEFT),
                'organization_id' => $item->organization_id,
                'organization'    => $organizationNames[$item->organization_id] ?? '',
                'tech_packs'      => $this->techPacks($techPackRows->get($item->id)),   
            ];
        });
 
        // Kits and shoots for the modals + item labels (soft-deleted ones are excluded automatically)
        $kits   = Kit::orderByDesc('id')->get()->map(fn ($kit) => $this->formatKit($kit))->values();
        $shoots = Shoot::orderByDesc('id')->get()->map(fn ($shoot) => $this->formatShoot($shoot))->values();
 
        return view('pages.studio_order.index', array_merge(compact(
            'studioItems',
            'organizationData',
            'productCategoryData',
            'kits',
            'shoots'
        ), $this->chatMentionData()));
    }
 
  
 
    public function storeKit(Request $request)
    {
        $validated = $request->validate([
            'kit_name'   => [
                'required', 'string', 'min:3', 'max:255',
                Rule::unique('kits', 'kit_name')->whereNull('deleted_at'),
            ],
            'item_ids'   => ['required', 'array', 'min:1'],
            'item_ids.*' => ['integer', $this->studioItemExistsRule()],
        ], [
            'kit_name.unique' => 'A kit with this name already exists. Use the "Existing Kits" tab to add to it.',
        ]);
 
        $kit = Kit::create([
            'kit_name'       => trim($validated['kit_name']),
            'order_item_ids' => $this->cleanIds($validated['item_ids']),
        ]);
 
        return response()->json([
            'success' => true,
            'message' => 'Kit created successfully.',
            'kit'     => $this->formatKit($kit),
        ]);
    }
 
 
    public function addItemsToKit(Request $request, Kit $kit)
    {
        $validated = $request->validate([
            'item_ids'   => ['required', 'array', 'min:1'],
            'item_ids.*' => ['integer', $this->studioItemExistsRule()],
        ]);
 
        $kit->order_item_ids = $this->mergeIds($kit->order_item_ids, $validated['item_ids']);
        $kit->save();
 
        return response()->json([
            'success' => true,
            'message' => 'Items added to kit.',
            'kit'     => $this->formatKit($kit),
        ]);
    }
 
    public function destroyKit(Kit $kit)
    {
        $kit->delete();   // soft delete
 
        return response()->json([
            'success' => true,
            'message' => 'Kit deleted.',
        ]);
    }
 
 
    public function storeShoot(Request $request)
    {
        $validated = $request->validate([
            'shoot_name'     => ['required', 'string', 'min:3', 'max:255'],
            'shoot_date'     => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'item_ids'       => ['required', 'array', 'min:1'],
            'item_ids.*'     => ['integer', $this->studioItemExistsRule()],
        ], [
            'shoot_date.after_or_equal' => 'Shoot date cannot be in the past.',
        ]);
 
        // ONE item = ONE shoot
        $this->abortIfItemsInOtherShoots($validated['item_ids']);
 
        // Shoot date must be on or after every item's ex factory date
        $this->abortIfExFactoryAfterShoot($validated['item_ids'], $validated['shoot_date'], 'shoot_date');
 
        // Shoot + its PM task + one PM sub task per item: all saved, or nothing saved
        $shoot = DB::transaction(function () use ($validated) {
            $shoot = Shoot::create([
                'shoot_name'     => trim($validated['shoot_name']),
                'shoot_date'     => $validated['shoot_date'],
                'order_item_ids' => $this->cleanIds($validated['item_ids']),
            ]);
 
            $this->createShootChat($shoot);
 
            return $shoot;
        });
 
        return response()->json([
            'success' => true,
            'message' => 'Shoot scheduled successfully.',
            'shoot'   => $this->formatShoot($shoot),
        ]);
    }
 
 
    public function addItemsToShoot(Request $request, Shoot $shoot)
    {
        $validated = $request->validate([
            'item_ids'   => ['required', 'array', 'min:1'],
            'item_ids.*' => ['integer', $this->studioItemExistsRule()],
        ]);
 
        // ONE item = ONE shoot (items already in THIS shoot are fine, they are just skipped)
        $this->abortIfItemsInOtherShoots($validated['item_ids'], $shoot->id);
 
        // New items must be ex factory on or before this shoot's date
        $this->abortIfExFactoryAfterShoot($validated['item_ids'], $shoot->shoot_date, 'item_ids');
 
        DB::transaction(function () use ($shoot, $validated) {
            $shoot->order_item_ids = $this->mergeIds($shoot->order_item_ids, $validated['item_ids']);
            $shoot->save();
 
            // New items get their own sub discussion (items that already have one are skipped)
            $this->createShootChat($shoot);
        });
 
        return response()->json([
            'success' => true,
            'message' => 'Items added to shoot.',
            'shoot'   => $this->formatShoot($shoot),
        ]);
    }
 
 
    public function destroyShoot(Shoot $shoot)
    {
        // Soft delete the shoot and its model assignments (shoot_person_items)
        DB::transaction(function () use ($shoot) {
            ShootPersonItem::where('shoot_id', $shoot->id)->get()->each->delete();
            $this->deleteShootChat($shoot);   // discussion + sub discussions + all chat comments
            $shoot->delete();
        });
 
        return response()->json([
            'success' => true,
            'message' => 'Shoot deleted.',
        ]);
    }
 
 
 
    /* =====================================================================
     | SHOOT SCHEDULE PAGE
     ===================================================================== */
 
 
    // GET orders/shoot-shedule   -> today + upcoming shoots (soonest first)
    public function shootSchedule()
    {
        $shootRows = Shoot::whereDate('shoot_date', '>=', Carbon::today())
            ->orderBy('shoot_date')
            ->orderByRaw('shoot_time IS NULL, shoot_time')   // shoots with a time first, then by time
            ->orderBy('id')
            ->get();
 
        // Same data builder as the Past Photo Shoots page (shootPageData() at the bottom)
        return view('pages.studio_order.shootschedule', $this->shootPageData($shootRows));
    }
 
    
    public function updateShootTime(Request $request, Shoot $shoot)
    {
        $validated = $request->validate([
            'shoot_time' => ['nullable', 'date_format:H:i'],
        ], [
            'shoot_time.date_format' => 'Please enter a valid time.',
        ]);
 
        $shoot->shoot_time = $validated['shoot_time'] ?? null;
        $shoot->save();
 
        return response()->json([
            'success' => true,
            'time'    => $this->formatShootTime($shoot->shoot_time),
        ]);
    }
 
    public function updateShootDate(Request $request, Shoot $shoot)
    {
        $validated = $request->validate([
            'shoot_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ], [
            'shoot_date.required'       => 'Please pick a shoot date.',
            'shoot_date.after_or_equal' => 'Shoot date cannot be in the past.',
        ]);
 
        // The new date cannot be before any item's ex factory date
        $this->abortIfExFactoryAfterShoot($shoot->order_item_ids ?? [], $validated['shoot_date'], 'shoot_date');
 
        DB::transaction(function () use ($shoot, $validated) {
            $shoot->shoot_date = $validated['shoot_date'];
            $shoot->save();
 
            $this->syncShootChat($shoot);  
        });
 
        return response()->json([
            'success' => true,
            'date'    => Carbon::parse($shoot->shoot_date)->format('Y-m-d'),
        ]);
    }
 
    public function updateShootName(Request $request, Shoot $shoot)
    {
        $validated = $request->validate([
            'shoot_name' => ['required', 'string', 'min:3', 'max:255'],
        ], [
            'shoot_name.required' => 'Please enter a shoot name.',
            'shoot_name.min'      => 'Shoot name must be at least 3 characters.',
        ]);
 
        // Trim and collapse double spaces ("Spring   Shoot" -> "Spring Shoot")
        DB::transaction(function () use ($shoot, $validated) {
            $shoot->shoot_name = preg_replace('/\s+/', ' ', trim($validated['shoot_name']));
            $shoot->save();
 
            $this->syncShootChat($shoot);   // PM task name follows the shoot name
        });
 
        return response()->json([
            'success' => true,
            'name'    => $shoot->shoot_name,
        ]);
    }
 
 
    
    public function updateShootNote(Request $request, Shoot $shoot)
    {
        $validated = $request->validate([
            'note' => ['nullable', 'string', 'max:500'],
        ]);
 
        $note = trim((string) ($validated['note'] ?? ''));
        $shoot->note = $note === '' ? null : $note;
        $shoot->save();
 
        return response()->json([
            'success' => true,
            'note'    => (string) ($shoot->note ?? ''),
        ]);
    }
 
    
    public function updateShootItemModel(Request $request, Shoot $shoot, OrderItem $item)
    {
        $validated = $request->validate([
            'fashion_model_id' => [
                'nullable', 'integer',
                Rule::exists('fashion_models', 'id')->whereNull('deleted_at'),
            ],
        ]);
 
        $this->ensureItemInShoot($shoot, $item);
        $modelId = $validated['fashion_model_id'] ?? null;
 
        DB::transaction(function () use ($shoot, $item, $modelId) {
            
            $this->detachItemFromShootPeople($shoot, $item->id);
 
           
            if ($modelId) {
                $row = ShootPersonItem::firstOrNew([
                    'shoot_id'         => $shoot->id,
                    'fashion_model_id' => $modelId,
                ]);
                $row->order_item_ids = $this->mergeIds($row->order_item_ids ?? [], [$item->id]);
                $row->save();
            }
        });
 
        return response()->json([
            'success'          => true,
            'fashion_model_id' => $modelId,
        ]);
    }
 
    
    public function removeShootItem(Shoot $shoot, OrderItem $item)
    {
        $this->ensureItemInShoot($shoot, $item);
 
        DB::transaction(function () use ($shoot, $item) {
            $shoot->order_item_ids = array_values(array_diff($this->cleanIds($shoot->order_item_ids ?? []), [$item->id]));
            $shoot->save();
 
            $this->detachItemFromShootPeople($shoot, $item->id);
 
            if ($shoot->discussion_id) {
                $this->deleteItemChats($shoot->discussion_id, [$item->id]);
            }
        });
 
        return response()->json(['success' => true]);
    }
 
    /**
     * ONE item = ONE shoot.
     */
    /**
     * The shoot date must be ON or AFTER the ex factory date of every item
     */
    private function abortIfExFactoryAfterShoot($itemIds, $shootDate, string $errorKey = 'shoot_date')
    {
        $itemIds = $this->cleanIds($itemIds);
        if (empty($itemIds) || empty($shootDate)) {
            return;
        }
 
        $shootDay = Carbon::parse($shootDate)->startOfDay();
        $late     = [];   // [name => ex factory Carbon]
 
        OrderItem::with('subProduct', 'product')->whereIn('id', $itemIds)->get()
            ->each(function ($item) use ($shootDay, &$late) {
                $exFactory = $this->parseDate($item->ex_factory_date);
                if ($exFactory && $exFactory->gt($shootDay)) {
                    $name = $item->display_name
                        ?: ($item->subProduct->product_name ?? null)
                        ?: ($item->product->product_name ?? null)
                        ?: ('Item #' . $item->id);
                    $late[] = ['name' => $name, 'date' => $exFactory];
                }
            });
 
        if (empty($late)) {
            return;
        }
 
        // Latest ex factory date first (that is the earliest possible shoot date)
        usort($late, fn ($a, $b) => $b['date']->timestamp <=> $a['date']->timestamp);
 
        $lines = [];
        foreach (array_slice($late, 0, 3) as $row) {
            $lines[] = '"' . $row['name'] . '" is ex factory on ' . $row['date']->format('M d, Y');
        }
        if (count($late) > 3) {
            $lines[] = 'and ' . (count($late) - 3) . ' more';
        }
 
        $message = implode(', ', $lines) . '. The shoot date must be on or after '
                 . $late[0]['date']->format('M d, Y') . '.';
 
        abort(response()->json([
            'message' => $message,
            'errors'  => [$errorKey => [$message]],
        ], 422));
    }
 
    private function abortIfItemsInOtherShoots(array $itemIds, $exceptShootId = null)
    {
        $itemIds = $this->cleanIds($itemIds);
        $taken   = [];   // [item_id => shoot name]
 
        Shoot::when($exceptShootId, fn ($q) => $q->where('id', '!=', $exceptShootId))
            ->get(['id', 'shoot_name', 'order_item_ids'])
            ->each(function ($shoot) use ($itemIds, &$taken) {
                foreach (array_intersect($itemIds, $this->cleanIds($shoot->order_item_ids ?? [])) as $itemId) {
                    $taken[$itemId] = $shoot->shoot_name;
                }
            });
 
        if (empty($taken)) {
            return;
        }
 
        $names = $this->orderItemNames(array_keys($taken));
        $lines = [];
        foreach (array_slice($taken, 0, 3, true) as $itemId => $shootName) {
            $lines[] = '"' . ($names[$itemId] ?? 'Item #' . $itemId) . '" is already in shoot "' . $shootName . '"';
        }
        if (count($taken) > 3) {
            $lines[] = 'and ' . (count($taken) - 3) . ' more';
        }
 
        $message = implode(', ', $lines) . '. One item can be in only one shoot. Remove it from that shoot first.';
 
        abort(response()->json([
            'message' => $message,
            'errors'  => ['item_ids' => [$message]],
        ], 422));
    }
 
    /** Only real studio items can be added to a kit / shoot */
    private function studioItemExistsRule()
    {
        return Rule::exists('order_items', 'id')->where('is_studio_item', 1);
    }
 
    
    private function cleanIds($ids)
    {
        return array_values(array_unique(array_map('intval', (array) $ids)));
    }
 
    /** Old ids + new ids, without duplicates */
    private function mergeIds($oldIds, $newIds)
    {
        return $this->cleanIds(array_merge((array) ($oldIds ?? []), (array) $newIds));
    }
 
    /** Same shape the blade / JavaScript uses */
    private function formatKit(Kit $kit)
    {
        $ids = $this->cleanIds($kit->order_item_ids ?? []);
 
        return [
            'id'         => $kit->id,
            'name'       => $kit->kit_name,
            'item_ids'   => $ids,
            'item_count' => count($ids),
            'created_at' => optional($kit->created_at)->format('Y-m-d'),
        ];
    }
 
    private function formatShoot(Shoot $shoot)
    {
        $ids = $this->cleanIds($shoot->order_item_ids ?? []);
 
        return [
            'id'         => $shoot->id,
            'name'       => $shoot->shoot_name,
            'date'       => $shoot->shoot_date ? Carbon::parse($shoot->shoot_date)->format('Y-m-d') : null,
            'item_ids'   => $ids,
            'item_count' => count($ids),
            'created_at' => optional($shoot->created_at)->format('Y-m-d'),
        ];
    }
 
 
    private function techPacks($rows)
    {
        if (!$rows || $rows->isEmpty()) {
            return [];
        }
 
        $result = [];
        $seen   = [];
 
        foreach ($rows as $row) {
            $paths = $this->splitList($row->tech_pack_images);
            $names = $this->splitList($row->tech_pack_image_name);
 
            foreach ($paths as $index => $path) {
                $url = $this->imageUrl($path);
                if (!$url || isset($seen[$url])) {
                    continue;   // skip empty values and duplicates
                }
                $seen[$url] = true;
 
                $result[] = [
                    'url'  => $url,
                    'name' => $names[$index] ?? basename(str_replace('\\', '/', $path)),
                ];
            }
        }
 
        return $result;
    }
 
 
    private function splitList($value)
    {
        if ($value === null || trim((string) $value) === '') {
            return [];
        }
 
        $decoded = json_decode($value, true);
        if (is_array($decoded)) {
            $list = [];
            array_walk_recursive($decoded, function ($v) use (&$list) {
                if (is_string($v) && trim($v) !== '') {
                    $list[] = trim($v);
                }
            });
            return $list;
        }
 
        if (is_string($decoded) && trim($decoded) !== '') {
            return [trim($decoded)];   // a single JSON string like "a.jpg"
        }
 
        return array_values(array_filter(array_map('trim', preg_split('/[,|]/', (string) $value))));
    }
 
 
    /** 422 if the item is not part of this shoot */
    private function ensureItemInShoot(Shoot $shoot, OrderItem $item)
    {
        if (!in_array($item->id, $this->cleanIds($shoot->order_item_ids ?? []), true)) {
            abort(response()->json([
                'message' => 'This item is not part of this shoot. Please refresh the page.',
            ], 422));
        }
    }
 
    /** Remove an item id from every model row of this shoot (empty rows are deleted) */
    private function detachItemFromShootPeople(Shoot $shoot, $itemId)
    {
        ShootPersonItem::where('shoot_id', $shoot->id)->get()->each(function ($row) use ($itemId) {
            $ids = $this->cleanIds($row->order_item_ids ?? []);
            if (!in_array((int) $itemId, $ids, true)) {
                return;
            }
 
            $left = array_values(array_diff($ids, [(int) $itemId]));
            if (empty($left)) {
                $row->delete();
            } else {
                $row->order_item_ids = $left;
                $row->save();
            }
        });
    }
 
    /** One shoot item in the shape the Shoot Schedule page uses */
    private function formatShootItem(OrderItem $item, $modelId, $modelName, array $kitNames)
    {
        $subProduct = $item->subProduct;
        $product    = $item->product;
 
        // IMAGE: sub product mockup_img_1 -> product mockup_img_1 (same as Studio Items)
        $imagePath = $subProduct->mockup_img_1 ?? null;
        if (empty($imagePath)) {
            $imagePath = $product->mockup_img_1 ?? null;
        }
 
        // NAME: display_name -> sub product name -> product name (same as Studio Items)
        $name = $item->display_name;
        if (empty($name)) {
            $name = $subProduct->product_name ?? null;
        }
        if (empty($name)) {
            $name = $product->product_name ?? '';
        }
 
        $styleIds = $product
            ? $product->productCategories->pluck('product_category_id')->filter()->map(fn ($id) => (int) $id)->unique()->values()->all()
            : [];
 
        $exFactory = $this->parseDate($item->ex_factory_date);
 
        return [
            'id'              => $item->id,
            'created_at'      => optional($item->created_at)->format('Y-m-d'),
            'image'           => $this->imageUrl($imagePath),
            'name'            => $name,
            'style_ids'       => $styleIds,
            'ex_factory_date' => $exFactory ? $exFactory->format('Y-m-d') : null,
            'order_id'        => $item->order_id,
            'kits'            => array_values(array_unique($kitNames)),
            'gender'          => $this->normalizeGender($item->gender),
            'model_id'        => $modelId,
            'model'           => $modelName,
        ];
    }
 
    /**
     * order_items.gender is saved as "Men" / "Women" / "all".
     */
    private function normalizeGender($value)
    {
        $g = strtolower(trim((string) $value));
 
        if (in_array($g, ['men', 'male', 'man', 'm'], true)) {
            return 'male';
        }
        if (in_array($g, ['women', 'female', 'woman', 'w', 'f'], true)) {
            return 'female';
        }
        if (in_array($g, ['all', 'unisex', 'uni', 'both'], true)) {
            return 'all';
        }
 
        return null;
    }
 
    /** "13:30:00" -> "13:30", empty -> "" */
    private function formatShootTime($value)
    {
        if (empty($value)) {
            return '';
        }
 
        try {
            return Carbon::parse($value)->format('H:i');
        } catch (\Throwable $e) {
            return '';
        }
    }
 
    /**
     * Returns a Carbon date, or null if empty / not valid.
     */
    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }
 
        try {
            return Carbon::createFromFormat('m/d/Y', str_replace('-', '/', trim($value)))->startOfDay();
        } catch (\Throwable $e) {
            try {
                return Carbon::parse($value)->startOfDay();
            } catch (\Throwable $e) {
                return null;
            }
        }
    }
 
    /**
     * 
     * Files are in the project ROOT "assets" folder.
     */
    private function imageUrl($path)
    {
        if (empty($path)) {
            return null;
        }
 
        // Already a full URL
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }
 
        // Clean the path: fix Windows slashes, remove leading "/" and any "assets/" prefix
        $path = str_replace('\\', '/', trim($path));
        $path = ltrim($path, '/');
        $path = preg_replace('#^assets/#i', '', $path);
 
        // Encode each part so spaces work in the URL ("Product Master" -> "Product%20Master")
        $encoded = implode('/', array_map('rawurlencode', explode('/', $path)));
 
        return asset('assets/' . $encoded);
    }
 
 
    public function shootModels()
    {
        $fashionModels = FashionModel::orderByDesc('created_at')
            ->orderByDesc('id')
            ->get()
            ->map(fn ($model) => $this->formatModelRow($model))
            ->values();
 
        return view('pages.studio_order.shoot_models', compact('fashionModels'));
    }
 
    
    public function shootModelCreate()
    {
        return view('pages.studio_order.shootmodel_create');
    }
 
   
    public function shootModelProfile($id)
    {
        $fashionModel = FashionModel::with('images', 'photoshootPhotos')->findOrFail($id);
 
        $model   = $this->formatModelProfile($fashionModel);
        $modelId = $fashionModel->id;
 
        return view('pages.studio_order.shootmodel_profile', compact('model', 'modelId'));
    }
 
 
    /* =====================================================================
       SHOOT MODELS - CREATE / UPDATE / DELETE
       ===================================================================== */
 
    
    public function storeShootModel(Request $request)
    {
        $validated = $request->validate(array_merge(
            $this->modelFieldRules(true),
            $this->measurementRules(true),
            [
                'profile_photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'images'              => ['nullable', 'array'],
                'images.*'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'photoshoot_photos'   => ['nullable', 'array', 'max:' . FashionModelPhotoshootPhoto::MAX_PHOTOS],
                'photoshoot_photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            ]
        ), $this->modelMessages());
 
        $model = DB::transaction(function () use ($request, $validated) {
            $data = $this->onlyModelFields($validated);
            foreach ($validated['measurements'] ?? [] as $key => $value) {
                $data[$key] = $this->toInches($value);
            }
 
            $model = FashionModel::create($data);   // age is filled from date_of_birth by the model
 
            // An age typed on the form wins over the calculated one
            if (array_key_exists('age', $validated) && $validated['age'] !== null && (int) $model->age !== (int) $validated['age']) {
                $model->age = (int) $validated['age'];
                $model->save();
            }
 
            // Profile photo
            $photo = $request->file('profile_photo');
            if ($photo instanceof UploadedFile) {
                $model->profile_photo = $this->storeModelFile($photo, $model);
                $model->save();
            }
 
            // Front / Right / Left / Back
            foreach (FashionModelImage::SIDES as $side) {
                $image = $request->file("images.$side");
                if ($image instanceof UploadedFile) {
                    $this->saveSideImage($model, $side, $image);
                }
            }
 
            // Previous photoshoot photos
            foreach ($this->uploadedFiles($request->file('photoshoot_photos')) as $file) {
                $this->savePhotoshootPhoto($model, $file);
            }
 
            return $model;
        });
 
        return response()->json([
            'success'  => true,
            'id'       => $model->id,
            'message'  => '"' . $model->name . '" was added.',
            'redirect' => route('studio.shoot.models.profile', ['id' => $model->id]),
        ]);
    }
 
   
    public function updateShootModel(Request $request, FashionModel $fashionModel)
    {
        $validated = $request->validate($this->modelFieldRules(false), $this->modelMessages());
 
        $data = $this->onlyModelFields($validated);
        unset($data['age']);
        $fashionModel->fill($data);
        $fashionModel->save();   // age follows date_of_birth when it changed
 
        // Age typed by hand (only when the date of birth was not changed in the same request)
        if (array_key_exists('age', $validated) && !array_key_exists('date_of_birth', $validated)) {
            $fashionModel->age = $validated['age'] === null ? null : (int) $validated['age'];
            $fashionModel->save();
        }
 
        return $this->modelResponse($fashionModel, 'Profile updated.');
    }
 
   
    public function updateShootModelMeasurements(Request $request, FashionModel $fashionModel)
    {
        $validated = $request->validate(array_merge(
            ['measurements' => ['required', 'array']],
            $this->measurementRules(false)
        ), $this->modelMessages());
 
        foreach ($validated['measurements'] as $key => $value) {
            if (array_key_exists($key, FashionModel::MEASUREMENTS)) {
                $fashionModel->{$key} = $this->toInches($value);
            }
        }
        $fashionModel->save();   // the model sets measurements_updated_at
 
        return $this->modelResponse($fashionModel, 'Measurements updated.');
    }
 
    
    public function destroyShootModel(FashionModel $fashionModel)
    {
        DB::transaction(function () use ($fashionModel) {
            // Items this model was wearing in shoots become "Not assigned"
            ShootPersonItem::where('fashion_model_id', $fashionModel->id)->delete();
            $fashionModel->delete();
        });
 
        return response()->json(['success' => true, 'message' => '"' . $fashionModel->name . '" deleted.']);
    }
 
 
    /* =====================================================================
       SHOOT MODELS - PHOTOS
       ===================================================================== */
 
   
    public function updateShootModelPhoto(Request $request, FashionModel $fashionModel)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], $this->modelMessages());
 
        $file = $request->file('photo');
        if (!$file instanceof UploadedFile) {
            return response()->json(['message' => 'Please choose a JPG, PNG or WEBP image.'], 422);
        }
 
        $old = $fashionModel->profile_photo;
        $fashionModel->profile_photo = $this->storeModelFile($file, $fashionModel);
        $fashionModel->save();
        $this->deleteStoredFile($old);
 
        return $this->modelResponse($fashionModel, 'Profile photo updated.');
    }
 
    
    public function storeShootModelImage(Request $request, FashionModel $fashionModel, $side)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], $this->modelMessages());
 
        $file = $request->file('image');
        if (!$file instanceof UploadedFile) {
            return response()->json(['message' => 'Please choose a JPG, PNG or WEBP image.'], 422);
        }
 
        $this->saveSideImage($fashionModel, $side, $file);
 
        return $this->modelResponse($fashionModel, ucfirst($side) . ' image saved.');
    }
 
    
    public function destroyShootModelImage(FashionModel $fashionModel, $side)
    {
        FashionModelImage::where('fashion_model_id', $fashionModel->id)
            ->where('side', $side)
            ->get()
            ->each(function ($image) {
                $this->deleteStoredFile($image->image_path);
                $image->delete();
            });
 
        return $this->modelResponse($fashionModel, ucfirst($side) . ' image deleted.');
    }
 
   
    public function storeShootModelPhotos(Request $request, FashionModel $fashionModel)
    {
        $request->validate([
            'photos'   => ['required', 'array', 'min:1'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], $this->modelMessages());
 
        $existing = FashionModelPhotoshootPhoto::where('fashion_model_id', $fashionModel->id)->count();
        $room     = FashionModelPhotoshootPhoto::MAX_PHOTOS - $existing;
        $files    = $this->uploadedFiles($request->file('photos'));
 
        if (count($files) > $room) {
            return response()->json([
                'message' => $room > 0
                    ? 'Only ' . FashionModelPhotoshootPhoto::MAX_PHOTOS . ' photos are allowed. You can add ' . $room . ' more.'
                    : 'This model already has ' . FashionModelPhotoshootPhoto::MAX_PHOTOS . ' photos.',
            ], 422);
        }
 
        foreach ($files as $file) {
            $this->savePhotoshootPhoto($fashionModel, $file);
        }
 
        return $this->modelResponse($fashionModel, count($files) . (count($files) === 1 ? ' photo' : ' photos') . ' uploaded.');
    }
 
    
    public function destroyShootModelPhoto(FashionModel $fashionModel, FashionModelPhotoshootPhoto $photo)
    {
        if ((int) $photo->fashion_model_id !== (int) $fashionModel->id) {
            abort(404);
        }
 
        $this->deleteStoredFile($photo->image_path);
        $photo->delete();
 
        return $this->modelResponse($fashionModel, 'Photo deleted.');
    }
 
    // DELETE orders/shoot-models/{fashionModel}/photoshoot-photos   (Remove all)
    public function clearShootModelPhotos(FashionModel $fashionModel)
    {
        FashionModelPhotoshootPhoto::where('fashion_model_id', $fashionModel->id)->get()->each(function ($photo) {
            $this->deleteStoredFile($photo->image_path);
            $photo->delete();
        });
 
        return $this->modelResponse($fashionModel, 'All photos deleted.');
    }
 
 
    /* =====================================================================
       SHOOT MODELS - HELPERS
       ===================================================================== */
 
    /** Personal info + experience rules. $creating = Add Model page (PATCH only checks the fields that are sent) */
    private function modelFieldRules(bool $creating): array
    {
        $required = $creating ? ['required'] : ['sometimes', 'required'];
        $optional = $creating ? ['nullable'] : ['sometimes', 'nullable'];
        $phone    = $creating ? ['required'] : ['sometimes', 'nullable'];
 
        return [
            'name'               => array_merge($required, ['string', 'min:2', 'max:255']),
            'address'            => array_merge($optional, ['string', 'max:1000']),
            'country'            => array_merge($optional, ['string', 'max:100']),
            'nationality'        => array_merge($optional, ['string', 'max:100']),
            'phone_number'       => array_merge($phone, ['string', 'max:20', 'regex:/^[+()\d\s-]{7,20}$/']),
            'email'              => array_merge($optional, ['email', 'max:255']),
            'age'                => array_merge($optional, ['integer', 'min:16', 'max:99']),
            'date_of_birth'      => array_merge($creating ? ['required'] : ['sometimes', 'nullable'], ['date', 'before_or_equal:today']),
            'gender'             => array_merge($required, [Rule::in(FashionModel::GENDERS)]),
            'us_size'            => array_merge($optional, ['string', 'max:50']),
            'model_type'         => array_merge($optional, [Rule::in(FashionModel::MODEL_TYPES)]),
            'experience'         => $creating ? ['nullable', 'boolean'] : ['sometimes', 'boolean'],
            'experience_details' => array_merge($optional, ['string', 'max:1000']),
        ];
    }
 
    /** measurements[key] in INCHES. Height is required on the Add Model page */
    private function measurementRules(bool $creating): array
    {
        $rules = ['measurements' => [$creating ? 'required' : 'sometimes', 'array']];
 
        foreach (array_keys(FashionModel::MEASUREMENTS) as $key) {
            $rules["measurements.$key"] = $key === 'height'
                ? [$creating ? 'required' : 'nullable', 'numeric', 'min:36', 'max:96']
                : ['nullable', 'numeric', 'gt:0', 'max:80'];
        }
 
        return $rules;
    }
 
    private function modelMessages(): array
    {
        $messages = [
            'name.required'                  => 'Please enter the model\'s full name.',
            'phone_number.required'          => 'Please enter a phone number.',
            'phone_number.regex'             => 'Please enter a valid phone number.',
            'email.email'                    => 'Please enter a valid email address.',
            'date_of_birth.required'         => 'Please pick the date of birth.',
            'date_of_birth.before_or_equal'  => 'Date of birth cannot be in the future.',
            'gender.required'                => 'Please choose a gender.',
            'age.min'                        => 'Age must be between 16 and 99.',
            'age.max'                        => 'Age must be between 16 and 99.',
            'measurements.height.required'   => 'Height is required.',
            'measurements.height.min'        => 'Height must be between 3 ft and 8 ft.',
            'measurements.height.max'        => 'Height must be between 3 ft and 8 ft.',
            'photoshoot_photos.max'          => 'Only ' . FashionModelPhotoshootPhoto::MAX_PHOTOS . ' photos are allowed.',
            'photos.required'                => 'Please choose at least one photo.',
        ];
 
        // image fields: wrong type / too big
        foreach (['profile_photo', 'photo', 'image', 'images.*', 'photoshoot_photos.*', 'photos.*'] as $field) {
            $messages["$field.image"] = 'Please choose a JPG, PNG or WEBP image.';
            $messages["$field.mimes"] = 'Please choose a JPG, PNG or WEBP image.';
            $messages["$field.max"]   = 'Each image must be 5 MB or smaller.';
        }
 
        foreach (FashionModel::MEASUREMENTS as $key => $label) {
            $messages["measurements.$key.numeric"] = "$label must be a number.";
            $messages["measurements.$key.gt"]      = "$label must be a positive number.";
            if ($key !== 'height') {
                $messages["measurements.$key.max"] = "$label looks too big. Please check it (inches).";
            }
        }
 
        return $messages;
    }
 
    /** Only the fashion_models columns from the validated data */
    private function onlyModelFields(array $validated): array
    {
        $fields = ['name', 'address', 'country', 'nationality', 'phone_number', 'email', 'age', 'date_of_birth', 'gender',
                   'us_size', 'model_type', 'experience', 'experience_details'];
 
        $data = array_intersect_key($validated, array_flip($fields));
 
        foreach (['name', 'address', 'country', 'nationality', 'phone_number', 'email', 'us_size', 'experience_details'] as $text) {
            if (array_key_exists($text, $data) && $data[$text] !== null) {
                $data[$text] = trim(preg_replace('/[ \t]+/', ' ', $data[$text]));
                if ($data[$text] === '') {
                    $data[$text] = null;
                }
            }
        }
        if (array_key_exists('experience', $data)) {
            $data['experience'] = (bool) $data['experience'];
        }
 
        return $data;
    }
 
    private function toInches($value)
    {
        return ($value === null || $value === '') ? null : round((float) $value, 2);
    }
 
    /** Save a file to storage/app/public/fashion_models/{id}/ and return the path */
    private function storeModelFile(UploadedFile $file, FashionModel $model): string
    {
        return $file->store('fashion_models/' . $model->id, 'public');
    }
 
    /** file() can return one file, a list of files or null -> always a list of real files */
    private function uploadedFiles($value): array
    {
        $list = is_array($value) ? $value : ($value ? [$value] : []);
 
        return array_values(array_filter($list, fn ($file) => $file instanceof UploadedFile));
    }
 
    private function deleteStoredFile($path)
    {
        if (!empty($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
 
    /** One image per side: replace the old one (the table has no unique key, so extra rows are cleaned) */
    private function saveSideImage(FashionModel $model, string $side, UploadedFile $file)
    {
        $path = $this->storeModelFile($file, $model);
 
        $rows = FashionModelImage::where('fashion_model_id', $model->id)->where('side', $side)->orderBy('id')->get();
        $keep = $rows->shift();
 
        foreach ($rows as $extra) {   // duplicates from before
            $this->deleteStoredFile($extra->image_path);
            $extra->delete();
        }
 
        if ($keep) {
            $this->deleteStoredFile($keep->image_path);
            $keep->image_path = $path;
            $keep->save();
        } else {
            FashionModelImage::create([
                'fashion_model_id' => $model->id,
                'side'             => $side,
                'image_path'       => $path,
            ]);
        }
    }
 
    private function savePhotoshootPhoto(FashionModel $model, UploadedFile $file)
    {
        FashionModelPhotoshootPhoto::create([
            'fashion_model_id' => $model->id,
            'image_path'       => $this->storeModelFile($file, $model),
            'original_name'    => mb_substr($file->getClientOriginalName(), 0, 255),
        ]);
    }
 
    /** JSON answer for the profile page: always sends the fresh profile back */
    private function modelResponse(FashionModel $model, string $message)
    {
        $model = FashionModel::with('images', 'photoshootPhotos')->findOrFail($model->id);
 
        return response()->json([
            'success'         => true,
            'message'         => $message,
            'model'           => $this->formatModelProfile($model),
        ]);
    }
 
    /** One row on the Shoot Models list */
    private function formatModelRow(FashionModel $model): array
    {
        return [
            'id'            => $model->id,
            'name'          => $model->name,
            'email'         => $model->email,
            'phone_number'  => $model->phone_number,
            'gender'        => $model->gender,
            'date_of_birth' => optional($model->date_of_birth)->format('Y-m-d'),
            'age'           => $model->age !== null ? (int) $model->age : null,
            'height_in'     => $model->height !== null ? (float) $model->height : null,
            'photo'         => $model->profile_photo_url,
            'registered'    => optional($model->created_at)->format('Y-m-d'),
        ];
    }
 
    /** Everything the Model Profile page needs */
    private function formatModelProfile(FashionModel $model): array
    {
        $measurements = [];
        foreach (array_keys(FashionModel::MEASUREMENTS) as $key) {
            $measurements[$key] = $model->{$key} !== null ? (float) $model->{$key} : null;
        }
 
        $history = $this->modelShootHistory($model);
 
        return [
            'id'                      => $model->id,
            'name'                    => $model->name,
            'address'                 => (string) ($model->address ?? ''),
            'country'                 => (string) ($model->country ?? ''),
            'nationality'             => (string) ($model->nationality ?? ''),
            'phone_number'            => (string) ($model->phone_number ?? ''),
            'email'                   => (string) ($model->email ?? ''),
            'age'                     => $model->age !== null ? (int) $model->age : null,
            'date_of_birth'           => optional($model->date_of_birth)->format('Y-m-d') ?? '',
            'gender'                  => (string) ($model->gender ?? ''),
            'us_size'                 => (string) ($model->us_size ?? ''),
            'model_type'              => (string) ($model->model_type ?? ''),
            'experience'              => (bool) $model->experience,
            'experience_details'      => (string) ($model->experience_details ?? ''),
            'photo'                   => $model->profile_photo_url,
            'images'                  => $model->sideImageUrls(),
            'measurements'            => $measurements,
            'measurements_updated_at' => optional($model->measurements_updated_at ?? $model->created_at)->format('Y-m-d\TH:i'),
            'created_at'              => optional($model->created_at)->format('Y-m-d\TH:i'),
            'shots'                   => $model->photoshootPhotos->map(fn ($photo) => [
                'id'   => $photo->id,
                'name' => $photo->original_name ?: basename($photo->image_path),
                'url'  => $photo->url,
                'date' => optional($photo->created_at)->format('Y-m-d'),
            ])->values()->all(),
            'projects'                => $history['upcoming'],  
            'past'                    => $history['past'],
        ];
    }
 
    /** Shoots this model is / was in, from shoot_person_items */
    private function modelShootHistory(FashionModel $model): array
    {
        $rows = ShootPersonItem::where('fashion_model_id', $model->id)->get();
        if ($rows->isEmpty()) {
            return ['upcoming' => [], 'past' => []];
        }
 
        // item ids per shoot (a model should have one row per shoot, but merge to be safe)
        $itemsByShoot = [];
        foreach ($rows as $row) {
            $itemsByShoot[$row->shoot_id] = array_values(array_unique(array_merge(
                $itemsByShoot[$row->shoot_id] ?? [],
                $this->cleanIds($row->order_item_ids ?? [])
            )));
        }
 
        $shoots    = Shoot::whereIn('id', array_keys($itemsByShoot))->get();   // soft-deleted shoots are skipped
        $itemNames = $this->orderItemNames(collect($itemsByShoot)->flatten()->unique()->values()->all());
        $today     = Carbon::today();
 
        $list = $shoots->map(function ($shoot) use ($itemsByShoot, $itemNames) {
            return [
                'id'    => $shoot->id,
                'name'  => $shoot->shoot_name,
                'date'  => $shoot->shoot_date ? Carbon::parse($shoot->shoot_date)->format('Y-m-d') : null,
                'time'  => $this->formatShootTime($shoot->shoot_time),
                'items' => collect($itemsByShoot[$shoot->id] ?? [])->map(fn ($id) => $itemNames[$id] ?? null)->filter()->values()->all(),
            ];
        });
 
        $upcoming = $list->filter(fn ($s) => $s['date'] && Carbon::parse($s['date'])->gte($today))
            ->sortBy(fn ($s) => $s['date'] . ' ' . ($s['time'] ?: '99:99'))->values()->all();
        $past = $list->filter(fn ($s) => !$s['date'] || Carbon::parse($s['date'])->lt($today))
            ->sortByDesc('date')->values()->all();
 
        return ['upcoming' => $upcoming, 'past' => $past];
    }

    private function orderItemNames(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        return OrderItem::with('subProduct', 'product')->whereIn('id', $ids)->get()
            ->mapWithKeys(function ($item) {
                $name = $item->display_name
                    ?: ($item->subProduct->product_name ?? null)
                    ?: ($item->product->product_name ?? null)
                    ?: ('Item #' . $item->id);

                return [$item->id => $name];
            })->all();
    }
 
    private function modelUpcomingShoots(array $modelIds): array
    {
        if (empty($modelIds)) {
            return [];
        }

        $rows = ShootPersonItem::whereIn('fashion_model_id', $modelIds)
            ->get(['shoot_id', 'fashion_model_id', 'order_item_ids']);
        if ($rows->isEmpty()) {
            return [];
        }

        $today  = Carbon::today();
        $shoots = Shoot::whereIn('id', $rows->pluck('shoot_id')->unique()->values())   // soft-deleted shoots are skipped
            ->get(['id', 'shoot_name', 'shoot_date', 'shoot_time'])
            ->filter(fn ($s) => $s->shoot_date && Carbon::parse($s->shoot_date)->gte($today))
            ->keyBy('id');

        $result = [];
        foreach ($rows as $row) {
            $shoot = $shoots->get($row->shoot_id);
            $count = count($this->cleanIds($row->order_item_ids ?? []));
            if (!$shoot || $count === 0) {
                continue;
            }

            $modelId = (int) $row->fashion_model_id;
            $key     = $shoot->id;   // one line per shoot (merge if a model has 2 rows in one shoot)

            if (isset($result[$modelId][$key])) {
                $result[$modelId][$key]['items'] += $count;
                continue;
            }

            $result[$modelId][$key] = [
                'id'    => $shoot->id,
                'name'  => $shoot->shoot_name,
                'date'  => Carbon::parse($shoot->shoot_date)->format('Y-m-d'),
                'time'  => $this->formatShootTime($shoot->shoot_time),
                'items' => $count,
            ];
        }

        return collect($result)->map(fn ($list) => collect($list)->sortBy(fn ($s) => $s['date'] . ' ' . ($s['time'] ?: '99:99'))->values()->all())->all();
    }

    /** 38 -> 38",  37.5 -> 37.5",  null -> null */
    private function inchLabel($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }
        $n = round((float) $value, 1);

        return (fmod($n, 1) == 0 ? (int) $n : $n) . '"';
    }
 
 
    // GET orders/shoot-past   -> shoots BEFORE today (newest first)
    // When a past shoot gets a new date (today or later) it shows on the schedule page again.
    public function pastPhotoShoot()
    {
        $shootRows = Shoot::whereDate('shoot_date', '<', Carbon::today())
            ->orderByDesc('shoot_date')
            ->orderByRaw('shoot_time IS NULL, shoot_time DESC')
            ->orderByDesc('id')
            ->get();
 
        return view('pages.studio_order.pastphoto_shoot', $this->shootPageData($shootRows));
    }
 
    /** Same data for both shoot pages: shoots (with items + models), fashion models, product styles */
    private function shootPageData($shootRows): array
    {
        // 1. All order items used by these shoots, in ONE query
        $allItemIds = $shootRows->flatMap(fn ($shoot) => $this->cleanIds($shoot->order_item_ids ?? []))->unique()->values();
 
        $orderItems = OrderItem::with('subProduct', 'product', 'product.productCategories')
            ->whereIn('id', $allItemIds)
            ->get()
            ->keyBy('id');
 
        // 2. Who wears which item: [shoot_id][order_item_id] = fashion_model_id
        $assignments = [];
        ShootPersonItem::whereIn('shoot_id', $shootRows->pluck('id'))->get()->each(function ($row) use (&$assignments) {
            foreach ($this->cleanIds($row->order_item_ids ?? []) as $itemId) {
                $assignments[$row->shoot_id][$itemId] = (int) $row->fashion_model_id;
            }
        });
 
        // 3. Fashion models (dropdown + names + profile photo)
        $fashionModelRows = FashionModel::orderBy('name')->get([
            'id', 'name', 'profile_photo', 'gender', 'age', 'us_size', 'model_type',
            'height', 'chest', 'waist', 'hips', 'phone_number', 'email',
        ]);
        $modelNames       = $fashionModelRows->pluck('name', 'id');
 
        // 4. Kit names per item (purple labels)
        $kitNamesByItem = [];
        Kit::orderByDesc('id')->get(['id', 'kit_name', 'order_item_ids'])->each(function ($kit) use (&$kitNamesByItem) {
            foreach ($this->cleanIds($kit->order_item_ids ?? []) as $itemId) {
                $kitNamesByItem[$itemId][] = $kit->kit_name;
            }
        });
 
        // 5. Chat comment count of each shoot's discussion, in ONE query
        $chatCounts = PmSectionDiscussion::whereIn('id', $shootRows->pluck('discussion_id')->filter()->unique()->values())
            ->withCount('comments')
            ->pluck('comments_count', 'id');
 
        // 5b. Chat comment count of each shoot item's sub discussion: [discussion_id][order_item_id] => count
        $itemChatCounts = [];
        PmSectionSubDiscussion::whereIn('discussion_id', $shootRows->pluck('discussion_id')->filter()->unique()->values())
            ->whereNotNull('order_item_id')
            ->withCount('comments')
            ->get(['id', 'discussion_id', 'order_item_id'])
            ->each(function ($sub) use (&$itemChatCounts) {
                $itemChatCounts[$sub->discussion_id][(int) $sub->order_item_id] = (int) $sub->comments_count;
            });
 
        // 6. Shoots list for the page
        $shoots = $shootRows->map(function ($shoot) use ($orderItems, $assignments, $modelNames, $kitNamesByItem, $chatCounts, $itemChatCounts) {
            $items = collect($this->cleanIds($shoot->order_item_ids ?? []))
                ->map(fn ($id) => $orderItems->get($id))
                ->filter()   // skip ids whose order item no longer exists
                ->map(function ($item) use ($shoot, $assignments, $modelNames, $kitNamesByItem, $itemChatCounts) {
                    $modelId = $assignments[$shoot->id][$item->id] ?? null;
                    if ($modelId && !isset($modelNames[$modelId])) {
                        $modelId = null;   // model was deleted
                    }
 
                    $row = $this->formatShootItem($item, $modelId, $modelId ? $modelNames[$modelId] : null, $kitNamesByItem[$item->id] ?? []);
                    $row['chat_count'] = $itemChatCounts[$shoot->discussion_id][$item->id] ?? 0;   // item chat badge
 
                    return $row;
                })
                ->values();
 
            return [
                'id'    => $shoot->id,
                'date'  => $shoot->shoot_date ? Carbon::parse($shoot->shoot_date)->format('Y-m-d') : null,
                'name'  => $shoot->shoot_name,
                'time'  => $this->formatShootTime($shoot->shoot_time),
                'note'  => (string) ($shoot->note ?? ''),
                'chat_count' => (int) ($chatCounts[$shoot->discussion_id] ?? 0),
                'items' => $items,
            ];
        })->values();
 
        // 7. Product Style filter: only categories used by these shoot items
        $styleIds = $shoots->flatMap(fn ($s) => collect($s['items'])->flatMap(fn ($i) => $i['style_ids']))->unique()->values();
        $styles   = ProductCategory::whereIn('id', $styleIds)
            ->orderBy('product_category_name')
            ->get(['id', 'product_category_name'])
            ->map(fn ($c) => ['id' => $c->id, 'name' => $c->product_category_name])
            ->values();
 
        $upcomingByModel = $this->modelUpcomingShoots($fashionModelRows->pluck('id')->all());

        $fashionModels = $fashionModelRows->map(fn ($m) => [
            'id'         => $m->id,
            'name'       => $m->name,
            'photo'      => $m->profile_photo_url,   // profile photo link, or null (initials are shown)

            // Hover card on the model button
            'code'       => $m->model_code,
            'gender'     => (string) ($m->gender ?? ''),
            'age'        => $m->age !== null ? (int) $m->age : null,
            'us_size'    => (string) ($m->us_size ?? ''),
            'model_type' => (string) ($m->model_type ?? ''),
            'height'     => $m->height_label,         // 5'9"
            'chest'      => $this->inchLabel($m->chest),
            'waist'      => $this->inchLabel($m->waist),
            'hips'       => $this->inchLabel($m->hips),
            'phone'      => (string) ($m->phone_number ?? ''),
            'email'      => (string) ($m->email ?? ''),
            'profile'    => route('studio.shoot.models.profile', ['id' => $m->id]),
            'upcoming'   => $upcomingByModel[$m->id] ?? [],   // [{id, name, date, time, items}]
        ])->values();
 
        return array_merge(compact('shoots', 'fashionModels', 'styles'), $this->chatMentionData());
    }
 
 
    public function shootChat(Shoot $shoot)
    {
        $discussion = DB::transaction(fn () => $this->createShootChat($shoot));
        $count      = count($this->cleanIds($shoot->order_item_ids ?? []));
 
        return response()->json([
            'success' => true,
            'chat'    => [
                'id'       => $discussion->id,
                'type'     => 'discussion',
                'title'    => $shoot->shoot_name,
                'subtitle' => 'Shoot · ' . $this->chatDate($shoot->shoot_date) . ' · ' . $count . ' ' . ($count === 1 ? 'item' : 'items'),
            ],
        ]);
    }
 
    public function itemChat(OrderItem $item)
    {
        abort_unless((int) $item->is_studio_item === 1, 404);
 
        // The shoot this item belongs to (newest one, same rule as the Studio Items page)
        $shoot = Shoot::orderByDesc('id')
            ->get(['id', 'shoot_name', 'shoot_date', 'order_item_ids', 'discussion_id'])
            ->first(fn ($s) => in_array((int) $item->id, $this->cleanIds($s->order_item_ids ?? []), true));
 
        if (!$shoot) {
            return response()->json([
                'message' => 'This item is not in a shoot yet. Add it to a shoot to start the chat.',
            ], 422);
        }
 
        $sub = DB::transaction(function () use ($shoot, $item) {
            $discussion = $this->createShootChat($shoot);
 
            return PmSectionSubDiscussion::where('discussion_id', $discussion->id)
                ->where('order_item_id', $item->id)
                ->first();
        });
 
        if (!$sub) {
            return response()->json(['message' => 'Could not open the chat for this item. Please refresh the page.'], 422);
        }
 
        return response()->json([
            'success' => true,
            'chat'    => [
                'id'       => $sub->id,
                'type'     => 'sub_discussion',
                'title'    => $sub->discussion_name,
                'subtitle' => 'Shoot: ' . $shoot->shoot_name . ' · ' . $this->chatDate($shoot->shoot_date),
            ],
        ]);
    }
 
    /**
     * Make sure the shoot has its PM discussion, and every item has its sub discussion.
     * Safe to call many times: anything that already exists is kept as it is.
     */
    private function createShootChat(Shoot $shoot): PmSectionDiscussion
    {
        $discussion = $shoot->discussion_id ? PmSectionDiscussion::find($shoot->discussion_id) : null;
 
        if (!$discussion) {
            $settings   = StudioSetting::allSettings();
            $projectId  = $settings['pm_project_id'];
            $sectionId  = $settings['pm_section_id'];
            $assigneeId = $this->defaultAssignee($settings['pm_shoot_assignee_id']);
 
            $discussion = PmSectionDiscussion::create([
                'project_id'      => $projectId,
                'section_id'      => $sectionId,
                'discussion_name' => $shoot->shoot_name,
                'due_date'        => $this->chatDueDate($shoot->shoot_date),  
                'is_completed'    => 0,
                'assignee_id'     => $assigneeId,                              
                'assigned_by'     => $assigneeId ? auth()->id() : null,
                'user_id'         => auth()->id(),                           
                'sort_index'      => ((int) PmSectionDiscussion::where('section_id', $sectionId)->max('sort_index')) + 1,
                'studio_status'   => 1,                                       
            ]);
 
            $this->logAssignee($discussion, $assigneeId);
 
            $shoot->discussion_id = $discussion->id;
            $shoot->save();
        }
 
        $this->addItemChats($discussion, $this->cleanIds($shoot->order_item_ids ?? []), $shoot->shoot_date);
 
        return $discussion;
    }
 
    /** One sub discussion per item (items that already have one are skipped) */
    private function addItemChats(PmSectionDiscussion $discussion, array $itemIds, $shootDate): void
    {
        if (empty($itemIds)) {
            return;
        }
 
        $existing = PmSectionSubDiscussion::where('discussion_id', $discussion->id)
            ->whereIn('order_item_id', $itemIds)
            ->pluck('order_item_id')
            ->map(fn ($id) => (int) $id)
            ->all();
 
        $missing = array_values(array_diff($itemIds, $existing));
        if (empty($missing)) {
            return;
        }
 
        $items      = OrderItem::with('orderItemProductDetails')->whereIn('id', $missing)->get()->keyBy('id');
        $sort       = (int) PmSectionSubDiscussion::where('discussion_id', $discussion->id)->max('sort_index');
        $assigneeId = $this->defaultAssignee(StudioSetting::setting('pm_item_assignee_id'));
        $dueDate    = $this->itemDueDate($shootDate);  
 
        foreach ($missing as $itemId) {
            $item = $items->get($itemId);
            if (!$item) {
                continue;   // order item was deleted
            }
 
            $sub = PmSectionSubDiscussion::create([
                'project_id'      => $discussion->project_id,   
                'section_id'      => $discussion->section_id,
                'discussion_id'   => $discussion->id,
                'order_item_id'   => $item->id,
                'discussion_name' => $this->itemChatName($item),
                'due_date'        => $dueDate,                             
                'is_completed'    => 0,
                'assignee_id'     => $assigneeId,                         
                'assigned_by'     => $assigneeId ? auth()->id() : null,
                'user_id'         => auth()->id(),                        
                'sort_index'      => ++$sort,
                'studio_status'   => 1,
            ]);
 
            $this->logAssignee($sub, $assigneeId, true);
        }
    }
 
    /** Shoot renamed / date changed -> update the PM task (and the due date of its sub tasks) */
    private function syncShootChat(Shoot $shoot): void
    {
        $discussion = $shoot->discussion_id ? PmSectionDiscussion::find($shoot->discussion_id) : null;
        if (!$discussion) {
            return;
        }
 
        $discussion->update([
            'discussion_name' => $shoot->shoot_name,
            'due_date'        => $this->chatDueDate($shoot->shoot_date),  
        ]);
 
        $itemDueDate = $this->itemDueDate($shoot->shoot_date);
        PmSectionSubDiscussion::where('discussion_id', $discussion->id)->get()
            ->each(fn ($sub) => $sub->update(['due_date' => $itemDueDate]));
    }
 
    /** Item removed from a shoot -> soft delete its sub discussion and chat comments */
    private function deleteItemChats($discussionId, array $itemIds): void
    {
        $subs = PmSectionSubDiscussion::where('discussion_id', $discussionId)
            ->whereIn('order_item_id', $itemIds)
            ->get();
 
        $this->deleteSubDiscussions($subs);
    }
 
    /** Shoot deleted -> soft delete the discussion, all sub discussions and all chat comments */
    private function deleteShootChat(Shoot $shoot): void
    {
        if (!$shoot->discussion_id) {
            return;
        }
 
        $discussionId = $shoot->discussion_id;
 
        $this->deleteSubDiscussions(PmSectionSubDiscussion::where('discussion_id', $discussionId)->get());
 
        PmSectionDiscussionComment::where('section_discussion_id', $discussionId)->get()->each->delete();
        PmInbox::where('discussion_id', $discussionId)->delete();   // PM inbox rows of this task (same as PM project delete)
 
        $discussion = PmSectionDiscussion::find($discussionId);
        if ($discussion) {
            $discussion->delete();
        }
    }
 
    private function deleteSubDiscussions($subs): void
    {
        if ($subs->isEmpty()) {
            return;
        }
 
        $subIds = $subs->pluck('id');
 
        // ->each->delete() = soft delete one by one, so audits are saved (files are kept)
        PmSectionDiscussionComment::whereIn('sub_section_discussion_id', $subIds)->get()->each->delete();
        PmInbox::whereIn('sub_discussion_id', $subIds)->delete();
 
        $subs->each->delete();
    }
 
    /** Sub discussion name: catalog name -> display name -> item no */
    private function itemChatName(OrderItem $item): string
    {
        $name = optional($item->orderItemProductDetails)->show_in_catalog_name;
 
        if (blank($name)) {
            $name = $item->display_name;
        }
        if (blank($name)) {
            $name = $item->item_no;
        }
        if (blank($name)) {
            $name = 'Item #' . $item->id;
        }
 
        return mb_substr(trim($name), 0, 255);
    }
 
    /** [order_item_id => comment count] of the items' sub discussions */
    private function itemChatCounts(array $itemIds): array
    {
        if (empty($itemIds)) {
            return [];
        }
 
        $counts = [];
 
        PmSectionSubDiscussion::where('studio_status', 1)
            ->whereIn('order_item_id', $itemIds)
            ->withCount('comments')
            ->orderBy('id')   // newest sub discussion wins
            ->get(['id', 'order_item_id'])
            ->each(function ($sub) use (&$counts) {
                $counts[(int) $sub->order_item_id] = (int) $sub->comments_count;
            });
 
        return $counts;
    }
 
    /** People and groups for @mentions in the studio chat */
    private function chatMentionData(): array
    {
        $chatUsers = User::select('id', 'name', 'profile_pic')
            ->where('active', '1')
            ->orderBy('name')
            ->get()
            ->map(fn ($u) => [
                'id'   => $u->id,
                'name' => $u->name,
                'pic'  => $u->profile_pic ? asset($u->profile_pic) : null,
            ])->values();
 
        $chatGroups = Role::whereNotIn('id', [1])
            ->where('active', '1')
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn ($r) => ['id' => $r->id, 'name' => $r->name])
            ->values();
 
        return compact('chatUsers', 'chatGroups');
    }
 
    private function chatDueDate($date)
    {
        return $date ? Carbon::parse($date)->format('Y-m-d') : null;
    }
 
    /** Shoot item sub task due date: shoot date - X days (Studio Settings, default 3: 2026-11-09 -> 2026-11-06) */
    private function itemDueDate($shootDate)
    {
        return $shootDate
            ? Carbon::parse($shootDate)->subDays((int) StudioSetting::setting('item_due_days_before_shoot'))->format('Y-m-d')
            : null;
    }
 
    /** Default assignee only if that user still exists and is active (else no assignee) */
    private function defaultAssignee(int $userId)
    {
        return User::where('id', $userId)->where('active', 1)->exists() ? $userId : null;
    }
 
    /** Same history row Project Management saves when a task is assigned (pm_task_assignees) */
    private function logAssignee($task, $assigneeId, bool $isSub = false): void
    {
        if (!$assigneeId) {
            return;
        }
 
        PmTaskAssignee::create([
            'project_id'        => $task->project_id,
            'section_id'        => $task->section_id,
            'discussion_id'     => $isSub ? $task->discussion_id : $task->id,
            'is_sub_discussion' => $isSub ? 1 : 0,
            'sub_discussion_id' => $isSub ? $task->id : null,
            'assignee_id'       => $assigneeId,
            'assigned_by'       => auth()->id(),
        ]);
    }
 
    private function chatDate($date): string
    {
        return $date ? Carbon::parse($date)->format('M d, Y') : 'No date';
    }
 
    public function studioSettings()
    {
        $settings = StudioSetting::allSettings();
 
        // Projects for the Project dropdown 
        $projects = Project::orderBy('project_name')
            ->get(['id', 'project_name', 'project_no'])
            ->map(fn ($p) => [
                'id'   => $p->id,
                'name' => $p->project_name ?: ('Project #' . $p->project_no),
                'no'   => $p->project_no,
            ])->values();
 
        // Sections of the saved project 
        $sections = $this->settingsSections($settings['pm_project_id']);
 
        // Active users for the two assignee dropdowns
         $users = User::with('userDetails:id,user_id,job_title')
            ->where('active', 1)
            ->orderBy('name')
            ->get(['id', 'name', 'profile_pic'])
            ->map(fn ($u) => [
                'id'    => $u->id,
                'name'  => $u->name,
                'role'  => trim((string) optional($u->userDetails)->job_title),   
                'photo' => $this->userPhotoUrl($u->profile_pic),
            ])->values();
 
        $meta = StudioSetting::lastChange();
 
        return view('pages.studio_order.studio_settings', compact('settings', 'projects', 'sections', 'users', 'meta'));
    }
 
 
    private function userPhotoUrl($path)
    {
        if (empty($path)) {
            return null;
        }
 
        
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }
 
       
        $path = ltrim(str_replace('\\', '/', trim($path)), '/');
        if (strpos($path, '/') === false) {
            $path = 'assets/img/user/' . $path;
        }
 
       
        if (strtolower(basename($path)) === 'default.png') {
            return null;
        }
 
       
        if (!file_exists(base_path($path))) {
            return null;
        }
 
        return asset(implode('/', array_map('rawurlencode', explode('/', $path))));
    }
 
    
    public function studioSettingsSections(Project $project)
    {
        return response()->json([
            'sections' => $this->settingsSections($project->id),
        ]);
    }
 
    
    public function updateStudioSettings(Request $request)
    {
        $validated = $request->validate([
            'pm_project_id' => [
                'required', 'integer',
                Rule::exists('projects', 'id')->whereNull('deleted_at'),
            ],
            'pm_section_id' => [
                'required', 'integer',
                Rule::exists('pm_sections', 'id')
                    ->where('project_id', (int) $request->input('pm_project_id'))
                    ->whereNull('deleted_at'),
            ],
            'pm_shoot_assignee_id' => [
                'required', 'integer',
                Rule::exists('users', 'id')->where('active', 1),
            ],
            'pm_item_assignee_id' => [
                'required', 'integer',
                Rule::exists('users', 'id')->where('active', 1),
            ],
            'item_due_days_before_shoot' => ['required', 'integer', 'min:0', 'max:30'],
        ], [
            'pm_project_id.required'              => 'Please choose a project.',
            'pm_project_id.exists'                => 'This project no longer exists.',
            'pm_section_id.required'              => 'Please choose a section.',
            'pm_section_id.exists'                => 'This section is not part of the chosen project.',
            'pm_shoot_assignee_id.required'       => 'Please choose a person.',
            'pm_shoot_assignee_id.exists'         => 'This person is not an active user.',
            'pm_item_assignee_id.required'        => 'Please choose a person.',
            'pm_item_assignee_id.exists'          => 'This person is not an active user.',
            'item_due_days_before_shoot.required' => 'Enter a whole number from 0 to 30.',
            'item_due_days_before_shoot.integer'  => 'Enter a whole number from 0 to 30.',
            'item_due_days_before_shoot.min'      => 'Enter a whole number from 0 to 30.',
            'item_due_days_before_shoot.max'      => 'Enter a whole number from 0 to 30.',
        ]);
 
        StudioSetting::saveMany($validated);
 
        return response()->json([
            'success'  => true,
            'message'  => 'Settings saved. New shoots will use them.',
            'settings' => StudioSetting::allSettings(),
            'meta'     => StudioSetting::lastChange(),
        ]);
    }
 
    
    private function settingsSections($projectId)
    {
        return PmSection::where('project_id', $projectId)
            ->orderBy('sort_index')
            ->orderBy('id')
            ->get(['id', 'section_name', 'project_id'])
            ->map(fn ($s) => [
                'id'         => $s->id,
                'name'       => $s->section_name,
                'project_id' => (int) $s->project_id,
            ])->values();
    }
}
