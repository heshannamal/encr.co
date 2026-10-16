<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Models\OrderFolder;
use App\Models\OrderItemFile;
class RunScript extends Controller
{
    function runScriptOne(){
        echo "Start Proccess<br>";
        // $directories = Storage::disk('google')->directories("1j7l3pi54vuSPD4x2Aemi7GhjjdIdsjYn");
        $allYears = Storage::disk('google')->listContents("1j7l3pi54vuSPD4x2Aemi7GhjjdIdsjYn");
        
        foreach($allYears as $year){
            
            if($year["type"] == "dir")
            {
                // echo "Main Folder: ".$year["name"]."<br>";
                
                // echo "Main Folder ID: ". substr($year["path"], strrpos($year["path"], '/') + 1) . "<br>";

                $orders = Storage::disk('google')->listContents($year["path"]);
                foreach($orders as $order){
                    //echo substr($order["name"], strrpos($order["name"], ' ') + 1);
                    // echo "  Order Folder: ".$order["name"]."<br>";
                    // echo "  Order Folder Path: ". substr($order["path"], strrpos($order["path"], '/') + 1) ."<br>";

                    $orderSubFolders = Storage::disk('google')->listContents($order["path"]);
                    foreach($orderSubFolders as $subFolder){
                        if($subFolder["name"] == "Production Pics")
                        {
                            $Production_Pics = substr($subFolder["path"], strrpos($subFolder["path"], '/') + 1);
                        }else if($subFolder["name"] == "Discussions"){
                            $Discussions = substr($subFolder["path"], strrpos($subFolder["path"], '/') + 1);
                        }else if($subFolder["name"] == "Tech Pack"){
                            $Tech_Pack = substr($subFolder["path"], strrpos($subFolder["path"], '/') + 1);
                        }else if($subFolder["name"] == "Production Layouts"){
                            $Production_Layouts = substr($subFolder["path"], strrpos($subFolder["path"], '/') + 1);
                        }else if($subFolder["name"] == "Mockups"){
                            $Mockups = substr($subFolder["path"], strrpos($subFolder["path"], '/') + 1);
                        }else if($subFolder["name"] == "Test Print"){
                            $Test_Print = substr($subFolder["path"], strrpos($subFolder["path"], '/') + 1);
                        }
                        
                    }

                    $orderFolder = new OrderFolder();
                    $orderFolder->order_id = substr($order["name"], strrpos($order["name"], ' ') + 1);
                    $orderFolder->order_folder_id = substr($year["path"], strrpos($year["path"], '/') + 1) . "/" . substr($order["path"], strrpos($order["path"], '/') + 1);
                    $folderLongPath = substr($year["path"], strrpos($year["path"], '/') + 1) . "/" . substr($order["path"], strrpos($order["path"], '/') + 1);
                    $orderFolder->tech_pack_folder_id = $folderLongPath . "/" . $Tech_Pack;
                    $orderFolder->mockups_folder_id = $folderLongPath . "/" . $Mockups;
                    $orderFolder->production_layouts_folder_id = $folderLongPath . "/" . $Production_Layouts;
                    $orderFolder->production_pics_folder_id = $folderLongPath . "/" . $Production_Pics;
                    $orderFolder->discussions_folder_id = $folderLongPath . "/" . $Discussions;
                    $orderFolder->test_print_folder_id = $folderLongPath . "/" . $Test_Print;
                    $orderFolder->save();

                    echo "Order: " . substr($order["name"], strrpos($order["name"], ' ') + 1) . "<br>";
                    echo "Order Folder ID: ". substr($year["path"], strrpos($year["path"], '/') + 1) . "/" . substr($order["path"], strrpos($order["path"], '/') + 1) . "<br>";
                    echo "Tech Pack Folder ID: ". substr($order["name"], strrpos($order["name"], ' ') + 1) . "/". $Tech_Pack . "<br>";
                    echo "Production Layout Folder ID: ".  $Production_Layouts . "<br>";
                    echo "Mockups Folder ID: ". $Mockups . "<br>";
                    echo "Production Pics Folder ID: ". $Production_Pics . "<br>";
                    echo "Discussions Folder ID: ". $Discussions . "<br>";
                    echo "Test Print Folder ID: " . $Test_Print . "<br>";

                }
                
                
            }
            

            // $folder = Storage::disk('google')->getMetadata($directory);
            // echo json_encode($folder);
            echo "<br>";
        }
        
        echo "End Proccess";
        
    }

    function runScriptTwo(){
        
        ini_set('max_execution_time', '0'); // for infinite time of execution 
        echo "Start Proccess";

        $allYears = Storage::disk('google')->listContents("1j7l3pi54vuSPD4x2Aemi7GhjjdIdsjYn");
        
        foreach($allYears as $year){
            
            if($year["type"] == "dir")
            {
                error_log($year["name"]);
                $orders = Storage::disk('google')->listContents($year["path"]);
                
                foreach($orders as $order){
                    // if(substr($order["name"], strrpos($order["name"], ' ') + 1) == 522)
                    // {
                        echo "Order: " . substr($order["name"], strrpos($order["name"], ' ') + 1) . "<br>";
                        $orderSubFolders = Storage::disk('google')->listContents($order["path"]);
                        foreach($orderSubFolders as $subFolder){
                            if($subFolder["name"] == "Production Pics")
                            {
                                $orderProdPics = Storage::disk('google')->listContents($subFolder["path"]);
                                foreach($orderProdPics as $pics)
                                {
                                    $prodPicEditDetails = OrderItemFile::where('order_id', substr($order["name"], strrpos($order["name"], ' ') + 1))->where('product_picture_edited_image_name', $pics["name"])->first();
                                    $prodPicRawDetails = OrderItemFile::where('order_id', substr($order["name"], strrpos($order["name"], ' ') + 1))->where('product_picture_raw_image_name', $pics["name"])->first();
                                    if(isset($prodPicEditDetails->id) && $prodPicEditDetails->id != null)
                                    {
                                        $prodPicEditDetailsUpdate = OrderItemFile:: find($prodPicEditDetails->id);
                                        $prodPicEditDetailsUpdate->product_picture_edited_images = "https://drive.google.com/uc?id=".$pics["basename"]."&export=media";
                                        $prodPicEditDetailsUpdate->update();
                                        //error_log("Done Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Prod Edit Pic: ". $pics["name"] );
                                    }else if(isset($prodPicRawDetails->id) && $prodPicRawDetails->id != null){
                                        $prodPicRawDetailsUpdate = OrderItemFile:: find($prodPicRawDetails->id);
                                        $prodPicRawDetailsUpdate->product_picture_raw_images = "https://drive.google.com/uc?id=".$pics["basename"]."&export=media";
                                        $prodPicRawDetailsUpdate->update();
    
                                        //error_log("Done Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Prod Raw Pic: ". $pics["name"] );
                                    }
                                    else{
                                        error_log("Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Prod Edit Pic: ". $pics["name"] );
                                    }
    
                                    
                                    // if(isset($prodPicRawDetails->id) && $prodPicRawDetails->id != null){
                                    //     $prodPicRawDetailsUpdate = OrderItemFile:: find($prodPicRawDetails->id);
                                    //     $prodPicRawDetailsUpdate->product_picture_raw_images = "https://drive.google.com/uc?id=".$pics["basename"]."&export=media";
                                    //     $prodPicRawDetailsUpdate->update();
    
                                    //     //error_log("Done Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Prod Raw Pic: ". $pics["name"] );
                                    // }
                                    // else{
                                    //     error_log("Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Prod Raw Pic: ". $pics["name"] );
                                    // }
                                    
                                }
                            }else if($subFolder["name"] == "Discussions"){
                                
                            }else if($subFolder["name"] == "Tech Pack"){
                                
                                $orderTechPacks = Storage::disk('google')->listContents($subFolder["path"]);
                                foreach($orderTechPacks as $techs)
                                {
                                    
                                    $techPackFileDetails = OrderItemFile::where('order_id', substr($order["name"], strrpos($order["name"], ' ') + 1))->where('tech_pack_file_name', $techs["name"])->first();
                                    $techPackImgDetails = OrderItemFile::where('order_id', substr($order["name"], strrpos($order["name"], ' ') + 1))->where('tech_pack_image_name', $techs["name"])->first();
                                    if(isset($techPackFileDetails->id) && $techPackFileDetails->id != null)
                                    {
                                        $techPackFileDetailsUpdate = OrderItemFile:: find($techPackFileDetails->id);
                                        $techPackFileDetailsUpdate->tech_pack_files = "https://drive.google.com/uc?id=".$techs["basename"]."&export=media";
                                        $techPackFileDetailsUpdate->update();
    
                                        // error_log("Done Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Techpack File: ". $techs["name"] );
                                    }else if(isset($techPackImgDetails->id) && $techPackImgDetails->id != null)
                                    {
                                        $techPackImgDetailsUpdate = OrderItemFile:: find($techPackImgDetails->id);
                                        $techPackImgDetailsUpdate->tech_pack_images = "https://drive.google.com/uc?id=".$techs["basename"]."&export=media";
                                        $techPackImgDetailsUpdate->update();
                                        //error_log("Done Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Techpack Image: ". $techs["name"] );
                                    }
                                    else{
                                        error_log("Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Techpack File: ". $techs["name"] );
                                    }
    
                                    
                                    // if(isset($techPackImgDetails->id) && $techPackImgDetails->id != null)
                                    // {
                                    //     $techPackImgDetailsUpdate = OrderItemFile:: find($techPackImgDetails->id);
                                    //     $techPackImgDetailsUpdate->tech_pack_images = "https://drive.google.com/uc?id=".$techs["basename"]."&export=media";
                                    //     $techPackImgDetailsUpdate->update();
                                    //     //error_log("Done Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Techpack Image: ". $techs["name"] );
                                    // }else{
                                    //     error_log("Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Techpack Image: ". $techs["name"] );
                                    // }
                                }
                               
                            }else if($subFolder["name"] == "Production Layouts"){
                                $orderProdLayouts = Storage::disk('google')->listContents($subFolder["path"]);
                                foreach($orderProdLayouts as $layout)
                                {
                                    $layoutDetails = OrderItemFile::where('order_id', substr($order["name"], strrpos($order["name"], ' ') + 1))->where('production_layout_image_name', $layout["name"])->first();
                                    if(isset($layoutDetails->id) && $layoutDetails->id != null)
                                    {
                                        $layoutDetailsUpdate = OrderItemFile:: find($layoutDetails->id);
                                        $layoutDetailsUpdate->production_layout_images = "https://drive.google.com/uc?id=".$layout["basename"]."&export=media";
                                        $layoutDetailsUpdate->update();
                                        //error_log("Done Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Layout: ". $layout["name"] );
                                    }
                                    else{
                                        error_log("Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Layout: ". $layout["name"] );
                                    }
                                }
                                
                            }else if($subFolder["name"] == "Mockups"){
    
                                $orderMockups = Storage::disk('google')->listContents($subFolder["path"]);
                                foreach($orderMockups as $mock)
                                {
                                    $mockDetails = OrderItemFile::where('order_id', substr($order["name"], strrpos($order["name"], ' ') + 1))->where('mockup_image_name', $mock["name"])->first();
                                    if(isset($mockDetails->id) && $mockDetails->id != null)
                                    {
                                        $mockDetailsUpdate = OrderItemFile:: find($mockDetails->id);
                                        $mockDetailsUpdate->mockup_images = "https://drive.google.com/uc?id=".$mock["basename"]."&export=media";
                                        $mockDetailsUpdate->update();
                                        //error_log("Done Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Mockup: ". $mock["name"] );
                                    }
                                    else{
                                        error_log("Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Mockup: ". $mock["name"] );
                                    }
                                }
                                
                            }else if($subFolder["name"] == "Test Print"){
                                $orderTestPrints = Storage::disk('google')->listContents($subFolder["path"]);
                                foreach($orderTestPrints as $testPrints)
                                {
                                    $printDetails = OrderItemFile::where('order_id', substr($order["name"], strrpos($order["name"], ' ') + 1))->where('test_print_image_name', $testPrints["name"])->first();
                                    if(isset($printDetails->id) && $printDetails->id != null){
                                        $printDetailsUpdate = OrderItemFile:: find($printDetails->id);
                                        $printDetailsUpdate->test_print_images = "https://drive.google.com/uc?id=".$testPrints["basename"]."&export=media";
                                        $printDetailsUpdate->update();
                                        //error_log("Done Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Test Print: ". $testPrints["name"] );
                                    }
                                    else{
                                        error_log("Order ID: ".substr($order["name"], strrpos($order["name"], ' ') + 1) . " ,Test Print: ". $testPrints["name"] );
                                    }
                                }
                            }
    
                            
                            
                        }
                    // }
                    
                } 
            }
            
            echo "<br>";
        }

        echo "End Proccess";
        ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
    }

    function testing(){

        //$techPackFileDetails = OrderItemFile:: find(3698);
        $techPackFileDetails = OrderItemFile::where('order_id', '531')->where('tech_pack_file_name', 'TECH PACK__EAST SIDE_ LACROSSE (1- 22)_FRONTIER GAME JERSEY.pdf')->first();

         echo json_encode($techPackFileDetails);    
        $techPackFileDetailsUpdate = OrderItemFile:: find($techPackFileDetails->id);
        $techPackFileDetailsUpdate->tech_pack_files = "shane";
        $techPackFileDetailsUpdate->update();
    }
}
