<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderFolder;
use App\Models\OrderItemFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function fileUpload(Request $request, $itemId, $orderId) {
        $order = Order::find($orderId);

        // Mockups
        if($request->has('mock_up_images')){
            $mockupImagePath = self::mockupImage($request, $orderId);

            foreach($mockupImagePath as $singleImagePath){
                $mockupImage = new OrderItemFile();
                $mockupImage->organization_id = $order->organization_id;
                $mockupImage->contact_id = $order->contact_id;
                $mockupImage->order_id = $orderId;
                $mockupImage->order_item_id = $itemId;
                $mockupImage->mockup_images = $singleImagePath['url'];
                $mockupImage->mockup_image_name = $singleImagePath['name'];
                $mockupImage->save();
            }
        }

        // Tech pack
        if($request->has('teck_pack_files')){
            $teckPackFilePath = self::teckPackFile($request, $orderId,$itemId);
            foreach($teckPackFilePath as $singleFilePath){
                // dd($singleFilePath );

                $teckPackFile = new OrderItemFile();
                $teckPackFile->organization_id = $order->organization_id;
                $teckPackFile->contact_id = $order->contact_id;
                $teckPackFile->order_id = $orderId;
                $teckPackFile->order_item_id = $itemId;
                $teckPackFile->tech_pack_files = $singleFilePath['url'];
                $teckPackFile->tech_pack_file_name = $singleFilePath['name'];
                $teckPackFile->save();
            }
        }

        if($request->has('teck_pack_images')){
            $teckPackImagePath = self::teckPackImage($request, $orderId,$itemId);

            foreach($teckPackImagePath as $singleImagePath){
                $teckPackImage = new OrderItemFile();
                $teckPackImage->organization_id = $order->organization_id;
                $teckPackImage->contact_id = $order->contact_id;
                $teckPackImage->order_id = $orderId;
                $teckPackImage->order_item_id = $itemId;
                $teckPackImage->tech_pack_images = $singleImagePath['url'];
                $teckPackImage->tech_pack_image_name = $singleImagePath['name'];
                $teckPackImage->save();
            }
        }

        // Production Layout
        if($request->has('production_layout_images')){
            $productionLayoutImagePath = self::productionLayoutImage($request, $orderId);

            foreach($productionLayoutImagePath as $singleImagePath){
                $productionLayoutImage = new OrderItemFile();
                $productionLayoutImage->organization_id = $order->organization_id;
                $productionLayoutImage->contact_id = $order->contact_id;
                $productionLayoutImage->order_id = $orderId;
                $productionLayoutImage->order_item_id = $itemId;
                $productionLayoutImage->production_layout_images = $singleImagePath['url'];
                $productionLayoutImage->production_layout_image_name = $singleImagePath['name'];
                $productionLayoutImage->save();
            }
        }

        // Cropped Photos
        if($request->has('test_print_images')){
            $croppedPhotosImagePath = self::testPrintImage($request, $orderId, $itemId);

            foreach($croppedPhotosImagePath as $singleImagePath){
                $croppedPhotosImage = new OrderItemFile();
                $croppedPhotosImage->organization_id = $order->organization_id;
                $croppedPhotosImage->contact_id = $order->contact_id;
                $croppedPhotosImage->order_id = $orderId;
                $croppedPhotosImage->order_item_id = $itemId;
                $croppedPhotosImage->test_print_images = $singleImagePath['url'];
                $croppedPhotosImage->test_print_image_name = $singleImagePath['name'];
                $croppedPhotosImage->save();
            }
        }

        // Product Picture
        if($request->has('product_picture_raw_images')){
            $productPictureFilePath = self::productPictureRawImage($request, $orderId, $itemId);

            foreach($productPictureFilePath as $singleImagePath){
                $productPictureFile = new OrderItemFile();
                $productPictureFile->organization_id = $order->organization_id;
                $productPictureFile->contact_id = $order->contact_id;
                $productPictureFile->order_id = $orderId;
                $productPictureFile->order_item_id = $itemId;
                $productPictureFile->product_picture_raw_images = $singleImagePath['url'];
                $productPictureFile->product_picture_raw_image_name = $singleImagePath['name'];
                $productPictureFile->save();
            }
        }

        if($request->has('product_picture_edited_images')){
            $productPictureImagePath = self::productPictureEditedImage($request, $orderId, $itemId);

            foreach($productPictureImagePath as $singleImagePath){
                $productPictureImage = new OrderItemFile();
                $productPictureImage->organization_id = $order->organization_id;
                $productPictureImage->contact_id = $order->contact_id;
                $productPictureImage->order_id = $orderId;
                $productPictureImage->order_item_id = $itemId;
                $productPictureImage->product_picture_edited_images = $singleImagePath['url'];
                $productPictureImage->product_picture_edited_image_name = $singleImagePath['name'];
                $productPictureImage->save();
            }
        }

        return json_encode('done');
    }

    public function mockupImage(Request $request, $orderId) {
        $files = $request->file('mock_up_images');

        $folderId = OrderFolder::where('order_id', $orderId)->first();

        $imagePath = [];
        $counter = 0;
        foreach($files as $file){
            foreach($file as $f){
                if($f->getClientOriginalExtension() == 'jpeg' || $f->getClientOriginalExtension() == 'JPEG' || $f->getClientOriginalExtension() == 'jpg' || $f->getClientOriginalExtension() == 'JPG' || $f->getClientOriginalExtension() == 'png' || $f->getClientOriginalExtension() == 'PNG' || $f->getClientOriginalExtension() == 'gif' || $f->getClientOriginalExtension() == 'GIF'){
                    $stored_file = Storage::disk('google')->putFileAs($folderId->mockups_folder_id, $f, $f->getClientOriginalName());
                    $url = Storage::disk('google')->url($stored_file);

                    $explodfile = explode('/',$stored_file);
                    $imageName = $f->getClientOriginalName();

                    $imagePath[$counter] = ['url'=>$url, 'name'=>$imageName];
                    $counter++;
                }
            }
        }
        return $imagePath;
    }

    // public function teckPackFile(Request $request, $orderId) {
    //     $files = $request->file('teck_pack_files');

    //     $folderId = OrderFolder::where('order_id', $orderId)->first();

    //     $filePath = [];
    //     $counter = 0;
    //     foreach($files as $file){
    //         foreach($file as $f){
    //             $stored_file = Storage::disk('google')->putFileAs($folderId->tech_pack_folder_id, $f, $f->getClientOriginalName());
    //             $url = Storage::disk('google')->url($stored_file);
    //             $explodfile = explode('/',$stored_file);
    //             $fileName = $f->getClientOriginalName();

    //             $filePath[$counter] = ['url'=>$url, 'name'=>$fileName];
    //             $counter++;
    //         }
    //     }
    //     return $filePath;
    // }

    public function teckPackFile(Request $request, $orderId,$itemId) {
        $files = $request->file('teck_pack_files');

        // Fetch the order details
        $order = Order::findOrFail($orderId); // Adjust based on your actual model name
        $orderYear = $order->created_at->format('Y'); // Get the year from the created_at date

        // Assuming you have a method to get the item ID for the current order


        // Define the destination path
        $destinationPath = public_path("order_files/{$orderYear}/{$orderId}/{$itemId}/TechPack");

        // Create the directory if it doesn't exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $filePath = [];
        $counter = 0;

        foreach ($files as $file) {
            foreach ($file as $f) {
                $extension = $f->getClientOriginalExtension();
                if (in_array(strtolower($extension), ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
                    $fileName = time() . '_' . $f->getClientOriginalName(); // Ensure unique file names
                    $stored_file = $f->move($destinationPath, $fileName); // Move file to the specified directory

                    // Construct URL
                    $url = asset("public/order_files/{$orderYear}/{$orderId}/{$itemId}/TechPack/{$fileName}");

                    $filePath[$counter] = ['url' => $url, 'name' => $fileName];
                    $counter++;
                }
            }
        }

        return $filePath; // Return as JSON for easier handling
    }

    // public function teckPackImage(Request $request, $orderId) {
    //     $files = $request->file('teck_pack_images');

    //     $folderId = OrderFolder::where('order_id', $orderId)->first();

    //     $imagePath = [];
    //     $counter = 0;
    //     foreach($files as $file){
    //         foreach($file as $f){
    //             if($f->getClientOriginalExtension() == 'jpeg' || $f->getClientOriginalExtension() == 'JPEG' || $f->getClientOriginalExtension() == 'jpg' || $f->getClientOriginalExtension() == 'JPG' || $f->getClientOriginalExtension() == 'png' || $f->getClientOriginalExtension() == 'PNG' || $f->getClientOriginalExtension() == 'gif' || $f->getClientOriginalExtension() == 'GIF'){
    //                 $stored_file = Storage::disk('google')->putFileAs($folderId->tech_pack_folder_id, $f, $f->getClientOriginalName());
    //                 $url = Storage::disk('google')->url($stored_file);

    //                 $explodfile = explode('/',$stored_file);
    //                 $imageName = $f->getClientOriginalName();

    //                 $imagePath[$counter] = ['url'=>$url, 'name'=>$imageName];
    //                 $counter++;
    //             }
    //         }
    //     }
    //     return $imagePath;
    // }
    public function teckPackImage(Request $request, $orderId, $itemId) {
        // Fetch the order details
        $order = Order::findOrFail($orderId); // Find the order by ID
        $orderYear = $order->created_at->format('Y'); // Get the year from the 'created_at' field

        // Define the destination path based on order and item details
        $destinationPath = public_path("order_files/{$orderYear}/{$orderId}/{$itemId}/TechPack");

        // Create the directory if it doesn't exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $files = $request->file('teck_pack_images'); // Retrieve uploaded image files
        $imagePath = []; // To store image URLs and names
        $counter = 0; // Counter for indexing the image paths

        // Loop through each uploaded file
        foreach ($files as $file) {
            foreach ($file as $f) {
                $extension = strtolower($f->getClientOriginalExtension()); // Get file extension and make lowercase
                if (in_array($extension, ['jpeg', 'jpg', 'png', 'gif'])) {
                    $imageName = time() . '_' . $f->getClientOriginalName(); // Generate unique image name
                    $stored_image = $f->move($destinationPath, $imageName); // Move image to the specified directory

                    // Construct the public URL to access the image
                    $url = asset("public/order_files/{$orderYear}/{$orderId}/{$itemId}/TechPack/{$imageName}");

                    // Store image details in the $imagePath array
                    $imagePath[$counter] = [
                        'url' => $url,
                        'name' => $imageName
                    ];
                    $counter++;
                }
            }
        }

        return $imagePath; // Return image URLs and names as JSON
    }

    public function productionLayoutImage(Request $request, $orderId) {
        $files = $request->file('production_layout_images');

        $folderId = OrderFolder::where('order_id', $orderId)->first();

        $imagePath = [];
        $counter = 0;
        foreach($files as $file){
            foreach($file as $f){
                if($f->getClientOriginalExtension() == 'jpeg' || $f->getClientOriginalExtension() == 'JPEG' || $f->getClientOriginalExtension() == 'jpg' || $f->getClientOriginalExtension() == 'JPG' || $f->getClientOriginalExtension() == 'png' || $f->getClientOriginalExtension() == 'PNG' || $f->getClientOriginalExtension() == 'gif' || $f->getClientOriginalExtension() == 'GIF'){
                    $stored_file = Storage::disk('google')->putFileAs($folderId->production_layouts_folder_id, $f, $f->getClientOriginalName());
                    $url = Storage::disk('google')->url($stored_file);

                    $explodfile = explode('/',$stored_file);
                    $imageName = $f->getClientOriginalName();

                    $imagePath[$counter] = ['url'=>$url, 'name'=>$imageName];
                    $counter++;
                }
            }
        }
        return $imagePath;
    }

    // public function testPrintImage(Request $request, $orderId) {
    //     $files = $request->file('test_print_images');

    //     $folderId = OrderFolder::where('order_id', $orderId)->first();

    //     $imagePath = [];
    //     $counter = 0;
    //     foreach($files as $file){
    //         foreach($file as $f){
    //             if($f->getClientOriginalExtension() == 'jpeg' || $f->getClientOriginalExtension() == 'JPEG' || $f->getClientOriginalExtension() == 'jpg' || $f->getClientOriginalExtension() == 'JPG' || $f->getClientOriginalExtension() == 'png' || $f->getClientOriginalExtension() == 'PNG' || $f->getClientOriginalExtension() == 'gif' || $f->getClientOriginalExtension() == 'GIF'){
    //                 $stored_file = Storage::disk('google')->putFileAs($folderId->test_print_folder_id, $f, $f->getClientOriginalName());
    //                 $url = Storage::disk('google')->url($stored_file);

    //                 $explodfile = explode('/',$stored_file);
    //                 $imageName = $f->getClientOriginalName();

    //                 $imagePath[$counter] = ['url'=>$url, 'name'=>$imageName];
    //                 $counter++;
    //             }
    //         }
    //     }
    //     return $imagePath;
    // }
    public function testPrintImage(Request $request, $orderId, $itemId) {
        // Fetch the order details
        $order = Order::findOrFail($orderId); // Find the order by ID
        $orderYear = $order->created_at->format('Y'); // Get the year from the 'created_at' field

        // Define the destination path based on order and item details
        $destinationPath = public_path("order_files/{$orderYear}/{$orderId}/{$itemId}/TestPrint");

        // Create the directory if it doesn't exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $files = $request->file('test_print_images'); // Retrieve uploaded test print images
        $imagePath = []; // To store image URLs and names
        $counter = 0; // Counter for indexing the image paths

        // Loop through each uploaded file
        foreach ($files as $file) {
            foreach ($file as $f) {
                $extension = strtolower($f->getClientOriginalExtension()); // Get file extension and make lowercase
                if (in_array($extension, ['jpeg', 'jpg', 'png', 'gif'])) {
                    $imageName = time() . '_' . $f->getClientOriginalName(); // Generate unique image name
                    $stored_image = $f->move($destinationPath, $imageName); // Move image to the specified directory

                    // Construct the public URL to access the image
                    $url = asset("public/order_files/{$orderYear}/{$orderId}/{$itemId}/TestPrint/{$imageName}");

                    // Store image details in the $imagePath array
                    $imagePath[$counter] = [
                        'url' => $url,
                        'name' => $imageName
                    ];
                    $counter++;
                }
            }
        }

        return $imagePath; // Return image URLs and names as JSON
    }


    // public function productPictureRawImage(Request $request, $orderId) {
    //     $files = $request->file('product_picture_raw_images');

    //     $folderId = OrderFolder::where('order_id', $orderId)->first();

    //     $imagePath = [];
    //     $counter = 0;
    //     foreach($files as $file){
    //         foreach($file as $f){
    //             if($f->getClientOriginalExtension() == 'jpeg' || $f->getClientOriginalExtension() == 'JPEG' || $f->getClientOriginalExtension() == 'jpg' || $f->getClientOriginalExtension() == 'JPG' || $f->getClientOriginalExtension() == 'png' || $f->getClientOriginalExtension() == 'PNG' || $f->getClientOriginalExtension() == 'gif' || $f->getClientOriginalExtension() == 'GIF'){
    //                 $stored_file = Storage::disk('google')->putFileAs($folderId->production_pics_folder_id, $f, $f->getClientOriginalName());
    //                 $url = Storage::disk('google')->url($stored_file);

    //                 $explodfile = explode('/',$stored_file);
    //                 $imageName = $f->getClientOriginalName();

    //                 $imagePath[$counter] = ['url'=>$url, 'name'=>$imageName];
    //                 $counter++;
    //             }
    //         }
    //     }
    //     return $imagePath;
    // }
    public function productPictureRawImage(Request $request, $orderId, $itemId) {
        // Fetch the order details
        $order = Order::findOrFail($orderId); // Find the order by ID
        $orderYear = $order->created_at->format('Y'); // Get the year from the 'created_at' field

        // Define the destination path based on order and item details
        $destinationPath = public_path("order_files/{$orderYear}/{$orderId}/{$itemId}/ProductPictures");

        // Create the directory if it doesn't exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $files = $request->file('product_picture_raw_images'); // Retrieve uploaded raw product images
        $imagePath = []; // To store image URLs and names
        $counter = 0; // Counter for indexing the image paths

        // Loop through each uploaded file
        foreach ($files as $file) {
            foreach ($file as $f) {
                $extension = strtolower($f->getClientOriginalExtension()); // Get file extension and make lowercase
                if (in_array($extension, ['jpeg', 'jpg', 'png', 'gif'])) {
                    $imageName = time() . '_' . $f->getClientOriginalName(); // Generate unique image name
                    $stored_image = $f->move($destinationPath, $imageName); // Move image to the specified directory

                    // Construct the public URL to access the image
                    $url = url("public/order_files/{$orderYear}/{$orderId}/{$itemId}/ProductPictures/{$imageName}");

                    // Store image details in the $imagePath array
                    $imagePath[$counter] = [
                        'url' => $url,
                        'name' => $imageName
                    ];
                    $counter++;
                }
            }
        }

        return $imagePath; // Return image URLs and names as JSON
    }


    // public function productPictureEditedImage(Request $request, $orderId) {
    //     $files = $request->file('product_picture_edited_images');

    //     $folderId = OrderFolder::where('order_id', $orderId)->first();

    //     $imagePath = [];
    //     $counter = 0;
    //     foreach($files as $file){
    //         foreach($file as $f){
    //             if($f->getClientOriginalExtension() == 'jpeg' || $f->getClientOriginalExtension() == 'JPEG' || $f->getClientOriginalExtension() == 'jpg' || $f->getClientOriginalExtension() == 'JPG' || $f->getClientOriginalExtension() == 'png' || $f->getClientOriginalExtension() == 'PNG' || $f->getClientOriginalExtension() == 'gif' || $f->getClientOriginalExtension() == 'GIF'){
    //                 $stored_file = Storage::disk('google')->putFileAs($folderId->production_pics_folder_id, $f, $f->getClientOriginalName());
    //                 $url = Storage::disk('google')->url($stored_file);

    //                 $explodfile = explode('/',$stored_file);
    //                 $imageName = $f->getClientOriginalName();

    //                 $imagePath[$counter] = ['url'=>$url, 'name'=>$imageName];
    //                 $counter++;
    //             }
    //         }
    //     }
    //     return $imagePath;
    // }

    public function productPictureEditedImage(Request $request, $orderId, $itemId) {
        // Fetch the order details
        $order = Order::findOrFail($orderId); // Find the order by ID
        $orderYear = $order->created_at->format('Y'); // Get the year from the 'created_at' field

        // Define the destination path based on order and item details
        $destinationPath = public_path("order_files/{$orderYear}/{$orderId}/{$itemId}/ProductPictures");

        // Create the directory if it doesn't exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $files = $request->file('product_picture_edited_images'); // Retrieve uploaded edited product images
        $imagePath = []; // To store image URLs and names
        $counter = 0; // Counter for indexing the image paths

        // Loop through each uploaded file
        foreach ($files as $file) {
            foreach ($file as $f) {
                $extension = strtolower($f->getClientOriginalExtension()); // Get file extension and make lowercase
                if (in_array($extension, ['jpeg', 'jpg', 'png', 'gif'])) {
                    $imageName = time() . '_' . $f->getClientOriginalName(); // Generate unique image name
                    $stored_image = $f->move($destinationPath, $imageName); // Move image to the specified directory

                    // Construct the public URL to access the image
                    $url = url("public/order_files/{$orderYear}/{$orderId}/{$itemId}/ProductPictures/{$imageName}");

                    // Store image details in the $imagePath array
                    $imagePath[$counter] = [
                        'url' => $url,
                        'name' => $imageName
                    ];
                    $counter++;
                }
            }
        }

        return $imagePath; // Return image URLs and names as JSON
    }


    public function fileDelete(Request $request, $orderId){
        $file = OrderItemFile::find($request->id);

        $folderId = OrderFolder::where('order_id', $orderId)->first();

        if ($file->mockup_images) {
            $fileURL = $file->mockup_images;
            $fileURL = substr($fileURL, strpos($fileURL, "=") + 1);
            $fileURL = strstr($fileURL, "&export", true);

            // Storage::disk('google')->delete($folderId->mockups_folder_id.'/'.$fileURL);

        } else if ($file->tech_pack_files) {
            $fileURL = $file->tech_pack_files;
            $fileURL = substr($fileURL, strpos($fileURL, "=") + 1);
            $fileURL = strstr($fileURL, "&export", true);

            // Storage::disk('google')->delete($folderId->tech_pack_folder_id.'/'.$fileURL);

        } else if ($file->tech_pack_images) {
            $fileURL = $file->tech_pack_images;
            $fileURL = substr($fileURL, strpos($fileURL, "=") + 1);
            $fileURL = strstr($fileURL, "&export", true);

            // Storage::disk('google')->delete($folderId->tech_pack_folder_id.'/'.$fileURL);

        } else if ($file->production_layout_images) {
            $fileURL = $file->production_layout_images;
            $fileURL = substr($fileURL, strpos($fileURL, "=") + 1);
            $fileURL = strstr($fileURL, "&export", true);

            // Storage::disk('google')->delete($folderId->production_layouts_folder_id.'/'.$fileURL);

        } else if ($file->product_picture_raw_images) {
            $fileURL = $file->product_picture_raw_images;
            $fileURL = substr($fileURL, strpos($fileURL, "=") + 1);
            $fileURL = strstr($fileURL, "&export", true);

            // Storage::disk('google')->delete($folderId->production_pics_folder_id.'/'.$fileURL);

        } else if ($file->product_picture_edited_images) {
            $fileURL = $file->product_picture_edited_images;
            $fileURL = substr($fileURL, strpos($fileURL, "=") + 1);
            $fileURL = strstr($fileURL, "&export", true);

            // Storage::disk('google')->delete($folderId->production_pics_folder_id.'/'.$fileURL);

        } else if ($file->test_print_images) {
            $fileURL = $file->test_print_images;
            $fileURL = substr($fileURL, strpos($fileURL, "=") + 1);
            $fileURL = strstr($fileURL, "&export", true);

            // Storage::disk('google')->delete($folderId->test_print_folder_id.'/'.$fileURL);
        }

        $file->delete();

        return json_encode($file);
    }
}
