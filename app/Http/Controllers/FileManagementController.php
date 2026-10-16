<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use App\Models\SharedItem;
use App\Models\User;
use App\Models\UserFolder;
use App\Models\UserRole;
use App\Models\UserTrashFolder;
use App\Models\UserSharedFolder;
use App\Models\UserTrashRecord;
use Illuminate\Filesystem\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class FileManagementController extends Controller
{
//  private $omsFolderId = '1l_By4keu_vx5N1oqbkjwilhipG5SWcq9';
//     private $storageFolderId = '1P05HI6aI2dG_ArtPzq-a4fCaymIou7dq';
//     private $trashFolderId = '11krUR6DHdQqFlekwypHQZk78WoOejJBZ';
//     private $sharedFolderId = '1SNZsJqYwAkbfIM6z7bUjnOAXT-RJobMd';
  
    private $omsFolderId = '1j7l3pi54vuSPD4x2Aemi7GhjjdIdsjYn';
    private $storageFolderId = '1_N2vrXnlrXC3_B_7GENhVqORaMBPH56F';
    private $trashFolderId = '1LD_Bh5mNaig5z9_GXh7pqZP34lkl_Xmh';
    private $sharedFolderId = '1VwPCwwUTTrXOQi7iQRblSzI-Co1CREtp';

    public function oms(Request $request){
        $omsFolderId = $this->omsFolderId;

        $users = User::where('active', 1)->orderBy('name')->get();

        $userGroups = Role::orderBy('name')->where('active', 1)->get();

        return view('pages.file_management.oms', ['omsFolderId'=>$omsFolderId, 'users'=>$users, 'userGroups'=>$userGroups]);
    }

    public function omsFolders(Request $request) {
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $directoryArray = explode('/', $request->folderId);
        foreach ($directoryArray as $directory) {
            $breadcrumbFolder = Storage::disk('google')->getMetadata($directory);

            $breadcrumbDirArray = array(
                'name' => $breadcrumbFolder['name'],
                'path' => $breadcrumbFolder['path'],
            );

            $breadcrumbFolders[] = (object) $breadcrumbDirArray;
        }
        $folderDir['breadcrumbs'] = $breadcrumbFolders;

        $directories = Storage::disk('google')->directories($request->folderId);

        if($directories){
            foreach($directories as $directory){
                $folder = Storage::disk('google')->getMetadata($directory);

                if(count($directoryArray) == 2){    // Apply only for orders
                    if (str_contains($folder['name'], 'Order ')) {
                        $orderName = explode(" ", $folder['name']);
                        $orderId = $orderName[1];

                        $orderQuery = Order::with('organizationDetails', 'orderItems');
                        if($oderSearch == 'factory'){
                            $orderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                                                    $qr->whereIn('factory_id', $factoryIds);
                                                });
                        }
                        $order = $orderQuery->where('id', $orderId)->first();

                        if($order){
                            $organizationName = $order->organizationDetails->organization_name;

                            $dirArray = array(
                                'name' => $folder['name'],
                                'path' => $folder['path'],
                                'organization' => $organizationName,
                            );

                            $folders[] = (object) $dirArray;
                        }
                    }

                } else { // Apply to all other
                    if (str_contains($folder['name'], 'Order ')) {
                        $orderName = explode(" ", $folder['name']);
                        $orderId = $orderName[1];

                        $orderQuery = Order::with('organizationDetails', 'orderItems');
                        if($oderSearch == 'factory'){
                            $orderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                                                    $qr->whereIn('factory_id', $factoryIds);
                                                });
                        }
                        $order = $orderQuery->where('id', $orderId)->first();

                        $organizationName = $order->organizationDetails->organization_name;

                    } else {
                        $organizationName = '';
                    }

                    $dirArray = array(
                        'name' => $folder['name'],
                        'path' => $folder['path'],
                        'organization' => $organizationName,
                    );

                    $folders[] = (object) $dirArray;
                }
            }

        } else {
            $folders = null;
        }

        if(isset($folders)){
            $folderDir['folders'] = $folders;
        } else {
            $folderDir['folders'] = null;
        }

        return json_encode($folderDir);
    }

    public function omsFiles(Request $request) {
        $files = Storage::disk('google')->files($request->folderId);

        if($files){
            foreach($files as $file){
                $fileUrl = explode('/', $file);
                $fileId = end($fileUrl);

                $details = Storage::disk('google')->getMetadata($file);

                $url = Storage::disk('google')->url($file);

                if($details['extension'] == 'jpg' || $details['extension'] == 'png') {
                    $fileUrl = $url;
                } else {
                    $fileUrl = '';
                }

                $dataArray = array(
                    'name' => $details['name'],
                    'path' => $details['path'],
                    'extension' => $details['extension'],
                    'url' => $fileUrl,
                    'timestamp' => $details['timestamp'],
                    'mimetype' => $details['mimetype'],
                    'size' => $details['size'],
                    'id' => $fileId,
                );

                $fileDatails[] = (object) $dataArray;
            }

        } else {
            $fileDatails = null;
        }

        if(isset($fileDatails)){
            $fileDatails = $fileDatails;
        } else {
            $fileDatails = null;
        }

        return json_encode($fileDatails);
    }

    public function myDrive(){
        if(auth()->user()->can('manage my drive')){
            $users = User::where('active', 1)->orderBy('name')->get();

            $userGroups = Role::orderBy('name')->where('active', 1)->get();

            $userFolderId = UserFolder::where('user_id', Auth::user()->id)->first();

            $userPath = '';
            if ($userFolderId) {
                $userPath = $userFolderId->user_folder_id;

            } else {
                Storage::disk('google')->makeDirectory($this->storageFolderId.'/'.'User_'.Auth::user()->id);

                $directories = Storage::disk('google')->directories($this->storageFolderId);

                foreach($directories as $directory){
                    $folder = Storage::disk('google')->getMetadata($directory);

                    if ($folder['name'] == 'User_'.Auth::user()->id) {
                        $userPath = $folder['path'];

                        $userFolder = new UserFolder();
                        $userFolder->user_id = Auth::user()->id;
                        $userFolder->user_folder_id = $userPath;
                        $userFolder->save();
                    }
                }
            }

            return view('pages.file_management.my_drive', ['users'=>$users, 'userGroups'=>$userGroups, 'userPath'=>$userPath]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function myDriveFolders(Request $request) { // used for My Drive, Shared with Me
        $directoryArray = explode('/', $request->folderId);
        foreach ($directoryArray as $directory) {
            $breadcrumbFolder = Storage::disk('google')->getMetadata($directory);

            $breadcrumbDirArray = array(
                'name' => $breadcrumbFolder['name'],
                'path' => $breadcrumbFolder['path'],
            );

            $breadcrumbFolders[] = (object) $breadcrumbDirArray;
        }
        $folderDir['breadcrumbs'] = $breadcrumbFolders;

        $directories = Storage::disk('google')->directories($request->folderId);

        if($directories){
            foreach($directories as $directory){
                $folder = Storage::disk('google')->getMetadata($directory);

                $dirArray = array(
                    'name' => $folder['name'],
                    'path' => $folder['path'],
                    'id' => $directory,

                );

                $folders[] = (object) $dirArray;
            }

        } else {
            $folders = null;
        }

        if(isset($folders)){
            $folderDir['folders'] = $folders;
        } else {
            $folderDir['folders'] = null;
        }

        $folderDir['files'] = self::myDriveFiles($request);

        return json_encode($folderDir);
    }

    public function myDriveFiles(Request $request) { // used for My Drive, Shared with Me
        $files = Storage::disk('google')->files($request->folderId);

        if($files){
            foreach($files as $file){
                $fileUrl = explode('/', $file);
                $fileId = end($fileUrl);

                $details = Storage::disk('google')->getMetadata($file);

                $url = Storage::disk('google')->url($file);

                if($details['extension'] == 'jpg' || $details['extension'] == 'png') {
                    $fileUrl = $url;
                } else {
                    $fileUrl = '';
                }

                $dataArray = array(
                    'name' => $details['name'],
                    'path' => $details['path'],
                    'extension' => $details['extension'],
                    'url' => $fileUrl,
                    'timestamp' => $details['timestamp'],
                    'mimetype' => $details['mimetype'],
                    'size' => $details['size'],
                    'id' => $fileId,
                );

                $fileDatails[] = (object) $dataArray;
            }

        } else {
            $fileDatails = null;
        }

        if(isset($fileDatails)){
            $fileDatails = $fileDatails;
        } else {
            $fileDatails = null;
        }

        return $fileDatails;
    }

    public function allFiles(Request $request){
        $directories = Storage::disk('google')->directories();

        if($directories){
            foreach($directories as $directory){
                $folder = Storage::disk('google')->getMetadata($directory);

                $dirArray = array(
                    'name' => $folder['name'],
                    'path' => $folder['path'],
                );

                $folders[] = (object) $dirArray;
            }

        } else {
            $folders = null;
        }

        if(isset($folders)){
            $folders = $folders;
        } else {
            $folders = null;
        }

        $files = Storage::disk('google')->allFiles();

        if($files){
            // $fileData = collect();
            // foreach($files as $file) {
            //     $fileData->push([
            //         'file' => $file,
            //         'date' => Storage::disk('google')->lastModified($file)
            //     ]);
            // }
            // $newest = $fileData->sortByDesc('date');
            // $newArray = array_slice($newest, 0, 5, true);
            // dd(array_slice($newArray, 0, 2, true));

            foreach($files as $file){
                $details = Storage::disk('google')->getMetadata($file);

                $url = Storage::disk('google')->url($file);

                if($details['extension'] == 'jpg' || $details['extension'] == 'png') {
                    $fileUrl = $url;
                } else {
                    $fileUrl = '';
                }

                $dataArray = array(
                    'name' => $details['name'],
                    'extension' => $details['extension'],
                    'url' => $fileUrl,
                    'timestamp' => $details['timestamp'],
                    'mimetype' => $details['mimetype'],
                    'size' => $details['size'],
                );

                $fileDatails[] = (object) $dataArray;
            }

        } else {
            $fileDatails = null;
        }

        if(isset($fileDatails)){
            $fileDatails = $fileDatails;
        } else {
            $fileDatails = null;
        }

        return view('pages.file_management.all_files', ['folders'=>$folders, 'fileDatails'=>$fileDatails]);
    }

    function printFile($service, $fileId) {
        try {
          $file = $service->files->get($fileId);

          print "Title: " . $file->getTitle();
          print "Description: " . $file->getDescription();
          print "MIME type: " . $file->getMimeType();
        } catch (Exception $e) {
          print "An error occurred: " . $e->getMessage();
        }
    }

    public function recents(){
        if(auth()->user()->can('manage recent')){
            $folders = array('Mockups', 'Product Pictures', 'Production Layouts', 'Teckpacks');
            return view('pages.file_management.recents', ['folders'=>$folders]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function fileShare(){
        if(auth()->user()->can('manage file share')){
            $userId = Auth::user()->id;
            $userSharedFolder = UserSharedFolder::where('user_id', $userId)->first();

            $userSharedFolderId = '';
            if ($userSharedFolder) {
                $userSharedFolderId = $userSharedFolder->user_shared_folder_id;

            } else {
                $userSharedFolderId = self::createSharedFolder($userId);
            }

            $userFolderId = UserFolder::where('user_id', Auth::user()->id)->first();

            $userPath = '';
            if ($userFolderId) {
                $userPath = $userFolderId->user_folder_id;

            } else {
                Storage::disk('google')->makeDirectory($this->storageFolderId.'/'.'User_'.Auth::user()->id);

                $directories = Storage::disk('google')->directories($this->storageFolderId);

                foreach($directories as $directory){
                    $folder = Storage::disk('google')->getMetadata($directory);

                    if ($folder['name'] == 'User_'.Auth::user()->id) {
                        $userPath = $folder['path'];

                        $userFolder = new UserFolder();
                        $userFolder->user_id = Auth::user()->id;
                        $userFolder->user_folder_id = $userPath;
                        $userFolder->save();
                    }
                }
            }

            $users = User::where('active', 1)->orderBy('name')->get();

            $userGroups = Role::orderBy('name')->where('active', 1)->get();

            return view('pages.file_management.share', [
                'userSharedFolderId'=>$userSharedFolderId, 'userPath'=>$userPath, 'users'=>$users, 'userGroups'=>$userGroups
            ]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function shareFolders(Request $request) {
        $directoryArray = explode('/', $request->folderId);
        foreach ($directoryArray as $directory) {
            $breadcrumbFolder = Storage::disk('google')->getMetadata($directory);

            $breadcrumbDirArray = array(
                'name' => $breadcrumbFolder['name'],
                'path' => $breadcrumbFolder['path'],
            );

            $breadcrumbFolders[] = (object) $breadcrumbDirArray;
        }
        $folderDir['breadcrumbs'] = $breadcrumbFolders;

        $directories = Storage::disk('google')->directories($request->folderId);

        if($directories){
            foreach($directories as $directory){
                $folder = Storage::disk('google')->getMetadata($directory);

                $dirArray = array(
                    'name' => $folder['name'],
                    'path' => $folder['path'],
                    'id' => $directory,

                );

                $folders[] = (object) $dirArray;
            }

        } else {
            $folders = null;
        }

        if(isset($folders)){
            $folderDir['folders'] = $folders;
        } else {
            $folderDir['folders'] = null;
        }

        $folderDir['files'] = self::shareFiles($request);

        return json_encode($folderDir);
    }

    public function shareFiles(Request $request) {
        $files = Storage::disk('google')->files($request->folderId);

        if($files){
            foreach($files as $file){
                $fileUrl = explode('/', $file);
                $fileId = end($fileUrl);

                $details = Storage::disk('google')->getMetadata($file);

                $url = Storage::disk('google')->url($file);

                if($details['extension'] == 'jpg' || $details['extension'] == 'png') {
                    $fileUrl = $url;
                } else {
                    $fileUrl = '';
                }

                $dataArray = array(
                    'name' => $details['name'],
                    'path' => $details['path'],
                    'extension' => $details['extension'],
                    'url' => $fileUrl,
                    'timestamp' => $details['timestamp'],
                    'mimetype' => $details['mimetype'],
                    'size' => $details['size'],
                    'id' => $fileId,
                );

                $fileDatails[] = (object) $dataArray;
            }

        } else {
            $fileDatails = null;
        }

        if(isset($fileDatails)){
            $fileDatails = $fileDatails;
        } else {
            $fileDatails = null;
        }

        return $fileDatails;
    }

    public function createSharedFolder($userId) {
        Storage::disk('google')->makeDirectory($this->sharedFolderId.'/'.'User_'.$userId);

        $directories = Storage::disk('google')->directories($this->sharedFolderId);

        $userSharedFolderId = '';
        foreach($directories as $directory){
            $folder = Storage::disk('google')->getMetadata($directory);

            if ($folder['name'] == 'User_'.$userId) {
                $userSharedFolderId = $folder['path'];

                $userSharedFolder = new UserSharedFolder();
                $userSharedFolder->user_id = $userId;
                $userSharedFolder->user_shared_folder_id = $userSharedFolderId;
                $userSharedFolder->save();
            }
        }

        return $userSharedFolderId;
    }

    public function folderHierarchy(Request $request) {
        $userFolder = UserFolder::where('user_id', Auth::user()->id)->first();

        $directories = Storage::disk('google')->directories($userFolder->user_folder_id);

        if($directories){
            foreach($directories as $directory){
                $folder = Storage::disk('google')->getMetadata($directory);

                $subFolderDir= self::subFolderHierarchy($folder['path']);

                $dirArray = array(
                    'name' => $folder['name'],
                    'path' => $folder['path'],
                    'subFolders' => $subFolderDir,
                );

                $folders[] = (object) $dirArray;
            }

        } else {
            $folders = null;
        }

        if(isset($folders)){
            $folderDir = $folders;
        } else {
            $folderDir = null;
        }

        return json_encode($folderDir);
    }

    public function subFolderHierarchy($directory) {
        $directories = Storage::disk('google')->directories($directory);

        if($directories){
            foreach($directories as $directory){
                $folder = Storage::disk('google')->getMetadata($directory);

                $subFolderDir = self::subFolderHierarchy($folder['path']);

                $dirArray = array(
                    'name' => $folder['name'],
                    'path' => $folder['path'],
                    'subFolders' => $subFolderDir,
                );

                $folders[] = (object) $dirArray;
            }

        } else {
            $folders = null;
        }

        if(isset($folders)){
            $folderDir = $folders;
        } else {
            $folderDir = null;
        }

        return $folderDir;
    }

    public function fileShareFolders(Request $request) {
        $sharedFolders = SharedItem::where('user_id', Auth::user()->id)->where('share_type', 1)->where('active', 1)->get();

        if($sharedFolders){
            foreach($sharedFolders as $sharedFolder){
                $folder = Storage::disk('google')->getMetadata($sharedFolder->share_path);

                $dirArray = array(
                    'name' => $folder['name'],
                    'path' => $folder['path'],
                    'id' => $sharedFolder->share_path,
                    'item_id' => $sharedFolder->id,
                    'is_read' => $sharedFolder->is_read,
                    'is_write' => $sharedFolder->is_write,
                );

                $folders[] = (object) $dirArray;
            }

        } else {
            $folders = null;
        }

        if(isset($folders)){
            $folderDir['folders'] = $folders;
        } else {
            $folderDir['folders'] = null;
        }

        $folderDir['files'] = self::fileShareFiles($request);

        return json_encode($folderDir);
    }

    public function fileShareFiles(Request $request) {
        $sharedFiles = SharedItem::where('user_id', Auth::user()->id)->where('share_type', 2)->where('active', 1)->get();

        if($sharedFiles){
            foreach($sharedFiles as $file){
                $details = Storage::disk('google')->getMetadata($file->share_path);

                $url = Storage::disk('google')->url($file->share_path);

                if($details['extension'] == 'jpg' || $details['extension'] == 'png') {
                    $fileUrl = $url;
                } else {
                    $fileUrl = '';
                }

                $dataArray = array(
                    'name' => $details['name'],
                    'path' => $details['path'],
                    'extension' => $details['extension'],
                    'timestamp' => $details['timestamp'],
                    'mimetype' => $details['mimetype'],
                    'size' => $details['size'],
                    'url' => $fileUrl,
                    'id' => $file->share_path,
                    'item_id' => $file->id,
                    'is_read' => $file->is_read,
                    'is_write' => $file->is_write,
                );

                $fileDatails[] = (object) $dataArray;
            }

        } else {
            $fileDatails = null;
        }

        if(isset($fileDatails)){
            $fileDatails = $fileDatails;
        } else {
            $fileDatails = null;
        }

        return $fileDatails;
    }

    public function important(){
        if(auth()->user()->can('manage important')){
            $folders = array('Mockups', 'Product Pictures', 'Production Layouts', 'Teckpacks');

            return view('pages.file_management.important', ['folders'=>$folders]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function removeSharedItem(Request $request) {
        $sharedFiles = SharedItem::find($request->item_id);
        $sharedFiles->active = 0;
        $sharedFiles->update();

        return json_encode('Item Removed Successfully!');
    }

    public function removeFile(Request $request){
        $userTrashFolder = UserTrashFolder::where('user_id', Auth::user()->id)->first();

        $userTrashFolderId = '';
        if ($userTrashFolder) {
            $userTrashFolderId = $userTrashFolder->user_trash_folder_id;

        } else {
            $userTrashFolderId = self::createTrashFolder();
        }

        $details = Storage::disk('google')->getMetadata($request->file_id);
        $fileRemove = Storage::disk('google')->move($request->file_path, $userTrashFolderId.'/'.$details['name']);

        if ($fileRemove == true) {
            $trashRecord = new UserTrashRecord();
            $trashRecord->original_location = $request->current_folder_id;
            $trashRecord->trashed_location = $userTrashFolderId;
            $trashRecord->file_id = $request->file_id;
            $trashRecord->user_id = Auth::user()->id;
            $trashRecord->save();

            return json_encode('File Removed Successfully!');
        } else {
            return json_encode('Something went worng when removing file');
        }
    }

    public function removeFolder(Request $request){
        $userTrashFolder = UserTrashFolder::where('user_id', Auth::user()->id)->first();

        $userTrashFolderId = '';
        if ($userTrashFolder) {
            $userTrashFolderId = $userTrashFolder->user_trash_folder_id;

        } else {
            $userTrashFolderId = self::createTrashFolder();
        }

        $removingFolder = $request->folder_id;

        $folder = Storage::disk('google')->getMetadata($removingFolder);

        // remove parent folder
        $createNewDirectory = Storage::disk('google')->makeDirectory($userTrashFolderId.'/'.$folder['name']);
        $newDirectory = Storage::disk('google')->getMetadata($userTrashFolderId.'/'.$folder['name']);

        // reove parent files
        $details = Storage::disk('google')->files($removingFolder);
        foreach ($details as $detail) {
            $fileDetails = Storage::disk('google')->getMetadata($detail);
            Storage::disk('google')->move($detail, $newDirectory['path'].'/'.$fileDetails['name']);
        }

        // remove subfolders
        $subDirectories = Storage::disk('google')->directories($removingFolder);
        if ($subDirectories) {
            self::moveSubDirs($subDirectories, $newDirectory);
        }

        if ($createNewDirectory == true) {
            $trashRecord = new UserTrashRecord();
            $trashRecord->original_location = $request->current_folder_id;
            $trashRecord->trashed_location = $userTrashFolderId;
            $trashRecord->folder_id = $newDirectory['path'];
            $trashRecord->user_id = Auth::user()->id;
            $trashRecord->save();

            Storage::disk('google')->deleteDirectory($removingFolder);
            return json_encode('Folder Removed Successfully!');
        } else {
            return json_encode('Something went worng when removing folder');
        }
    }

    public function removeSubDirs($subDirectories, $newDirectory) {
        foreach($subDirectories as $subDirectory){
            $subFolder = Storage::disk('google')->getMetadata($subDirectory);
            Storage::disk('google')->makeDirectory($newDirectory['path'].'/'.$subFolder['name']);
            $newSubDirectory = Storage::disk('google')->getMetadata($newDirectory['path'].'/'.$subFolder['name']);

            $subDirDetails = Storage::disk('google')->files($subDirectory);
            foreach ($subDirDetails as $subDirDetail) {
                $subFileDetails = Storage::disk('google')->getMetadata($subDirDetail);
                Storage::disk('google')->move($subDirDetail, $newSubDirectory['path'].'/'.$subFileDetails['name']);
            }

            $subSubDirectories = Storage::disk('google')->directories($subDirectory);
            if ($subSubDirectories) {
                self::moveSubDirs($subSubDirectories, $newSubDirectory);
            }
        }
    }

    public function deleteFile(Request $request) {
        $deleteFile = Storage::disk('google')->delete($request->file_id);

        if ($deleteFile == true) {
            return json_encode('File Deleted Successfully!');
        } else {
            return json_encode('Something went worng when deleteing file');
        }
    }

    public function deleteFolder(Request $request) {
        $deleteFolder = Storage::disk('google')->deleteDirectory($request->file_path);

        if ($deleteFolder == true) {
            return json_encode('Folder Deleted Successfully!');
        } else {
            return json_encode('Something went worng when deleteing folder');
        }
    }

    public function emptyTrash(Request $request) {
        $emptyTrash = false;

        $directories = Storage::disk('google')->directories($request->current_folder_id);
        if($directories){
            foreach($directories as $directory){
                $folder = Storage::disk('google')->getMetadata($directory);
                $emptyTrash = Storage::disk('google')->deleteDirectory($folder['path']);
            }
        }

        $files = Storage::disk('google')->files($request->current_folder_id);
        if($files){
            foreach($files as $file){
                $details = Storage::disk('google')->getMetadata($file);
                $emptyTrash = Storage::disk('google')->delete($details['path']);
            }
        }

        if ($emptyTrash == true) {
            return json_encode('Trash Emptied Successfully!');
        } else {
            return json_encode('Something went worng when empting trash');
        }
    }

    public function restoreFile(Request $request) {
        $trashRecord = UserTrashRecord::where('file_id', $request->file_id)->first();

        $details = Storage::disk('google')->getMetadata($request->file_id);
        $restoreFile = Storage::disk('google')->move($trashRecord->trashed_location.'/'.$request->file_id, $trashRecord->original_location.'/'.$details['name']);

        if ($restoreFile == true) {
            return json_encode('File Restored Successfully!');
        } else {
            return json_encode('Something went worng when restoring file');
        }
    }

    public function restoreFolder(Request $request) {
        $restoringFolder = $request->folder_path;
        $trashRecord = UserTrashRecord::where('folder_id', $restoringFolder)->first();

        $folder = Storage::disk('google')->getMetadata($restoringFolder);

        // remove parent folder
        $createNewDirectory = Storage::disk('google')->makeDirectory($trashRecord->original_location.'/'.$folder['name']);
        $newDirectory = Storage::disk('google')->getMetadata($trashRecord->original_location.'/'.$folder['name']);

        // reove parent files
        $details = Storage::disk('google')->files($restoringFolder);
        foreach ($details as $detail) {
            $fileDetails = Storage::disk('google')->getMetadata($detail);
            Storage::disk('google')->move($detail, $newDirectory['path'].'/'.$fileDetails['name']);
        }

        // remove subfolders
        $subDirectories = Storage::disk('google')->directories($restoringFolder);
        if ($subDirectories) {
            self::moveSubDirs($subDirectories, $newDirectory);
        }

        if ($createNewDirectory == true) {
            Storage::disk('google')->deleteDirectory($restoringFolder);
            return json_encode('Folder Restored Successfully!');
        } else {
            return json_encode('Something went worng when restoring folder');
        }
    }

    public function trash(){
        if(auth()->user()->can('manage trash')){
            $userTrashFolder = UserTrashFolder::where('user_id', Auth::user()->id)->first();

            $userTrashFolderId = '';
            if ($userTrashFolder) {
                $userTrashFolderId = $userTrashFolder->user_trash_folder_id;

            } else {
                $userTrashFolderId = self::createTrashFolder();
            }

            return view('pages.file_management.trash', ['userTrashFolderId'=>$userTrashFolderId]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function createTrashFolder() {
        Storage::disk('google')->makeDirectory($this->trashFolderId.'/'.'User_'.Auth::user()->id);

        $directories = Storage::disk('google')->directories($this->trashFolderId);

        $userTrashFolderId = '';
        foreach($directories as $directory){
            $folder = Storage::disk('google')->getMetadata($directory);

            if ($folder['name'] == 'User_'.Auth::user()->id) {
                $userTrashFolderId = $folder['path'];

                $userTrashFolder = new UserTrashFolder();
                $userTrashFolder->user_id = Auth::user()->id;
                $userTrashFolder->user_trash_folder_id = $userTrashFolderId;
                $userTrashFolder->save();
            }
        }

        return $userSharedFolderId;
    }

    public function trashFolders(Request $request) { // used for My Drive, Shared with Me
        $directoryArray = explode('/', $request->folderId);
        foreach ($directoryArray as $directory) {
            $breadcrumbFolder = Storage::disk('google')->getMetadata($directory);

            $breadcrumbDirArray = array(
                'name' => $breadcrumbFolder['name'],
                'path' => $breadcrumbFolder['path'],
            );

            $breadcrumbFolders[] = (object) $breadcrumbDirArray;
        }
        $folderDir['breadcrumbs'] = $breadcrumbFolders;

        $directories = Storage::disk('google')->directories($request->folderId);

        if($directories){
            foreach($directories as $directory){
                $folder = Storage::disk('google')->getMetadata($directory);

                $dirArray = array(
                    'name' => $folder['name'],
                    'path' => $folder['path'],
                    'id' => $directory,

                );

                $folders[] = (object) $dirArray;
            }

        } else {
            $folders = null;
        }

        if(isset($folders)){
            $folderDir['folders'] = $folders;
        } else {
            $folderDir['folders'] = null;
        }

        $folderDir['files'] = self::trashFiles($request);

        return json_encode($folderDir);
    }

    public function trashFiles(Request $request) { // used for My Drive, Shared with Me
        $files = Storage::disk('google')->files($request->folderId);

        if($files){
            foreach($files as $file){
                $fileUrl = explode('/', $file);
                $fileId = end($fileUrl);

                $details = Storage::disk('google')->getMetadata($file);

                $url = Storage::disk('google')->url($file);

                if($details['extension'] == 'jpg' || $details['extension'] == 'png') {
                    $fileUrl = $url;
                } else {
                    $fileUrl = '';
                }

                $dataArray = array(
                    'name' => $details['name'],
                    'path' => $details['path'],
                    'extension' => $details['extension'],
                    'url' => $fileUrl,
                    'timestamp' => $details['timestamp'],
                    'mimetype' => $details['mimetype'],
                    'size' => $details['size'],
                    'id' => $fileId,
                );

                $fileDatails[] = (object) $dataArray;
            }

        } else {
            $fileDatails = null;
        }

        if(isset($fileDatails)){
            $fileDatails = $fileDatails;
        } else {
            $fileDatails = null;
        }

        return $fileDatails;
    }

    public function documents(){
        $files = Storage::disk('google')->allFiles();

        if($files){
            $fileNo = 0;
            foreach($files as $file){
                $details = Storage::disk('google')->getMetadata($file);

                $url = Storage::disk('google')->url($file);

                if(
                    $details['extension'] == 'doc' ||
                    $details['extension'] == 'docx' ||
                    $details['extension'] == 'ttf' ||
                    $details['extension'] == 'xls' ||
                    $details['extension'] == 'xlsx'||
                    $details['extension'] == 'xlsm' ||
                    $details['extension'] == 'csv') {

                    $dataArray = array(
                        'file_no' => $fileNo,
                        'name' => $details['name'],
                        'extension' => $details['extension'],
                        'timestamp' => $details['timestamp'],
                        'mimetype' => $details['mimetype'],
                        'size' => $details['size'],
                        'url' => $url
                    );

                    $fileDatails[] = (object) $dataArray;
                }
                $fileNo++;
            }

        } else {
            $fileDatails = null;
        }

        if(isset($fileDatails)){
            $fileDatails = $fileDatails;
        } else {
            $fileDatails = null;
        }

        return view('pages.file_management.documents', ['fileDatails'=>$fileDatails]);
    }

    public function images(){
        $files = Storage::disk('google')->allFiles();

        if($files){
            $fileNo = 0;
            foreach($files as $file){
                $details = Storage::disk('google')->getMetadata($file);

                $url = Storage::disk('google')->url($file);

                if(
                    $details['extension'] == 'jpg' ||
                    $details['extension'] == 'jpeg' ||
                    $details['extension'] == 'png') {

                    $dataArray = array(
                        'file_no' => $fileNo,
                        'name' => $details['name'],
                        'extension' => $details['extension'],
                        'timestamp' => $details['timestamp'],
                        'mimetype' => $details['mimetype'],
                        'size' => $details['size'],
                        'url' => $url
                    );

                    $fileDatails[] = (object) $dataArray;
                }
                $fileNo++;
            }

        } else {
            $fileDatails = null;
        }

        if(isset($fileDatails)){
            $fileDatails = $fileDatails;
        } else {
            $fileDatails = null;
        }

        return view('pages.file_management.images', ['fileDatails'=>$fileDatails]);
    }

    // public function videos(){
    //     $files = Storage::disk('google')->allFiles();

    //     if($files){
    //         $fileNo = 0;
    //         foreach($files as $file){
    //             $details = Storage::disk('google')->getMetadata($file);

    //             $url = Storage::disk('google')->url($file);

    //             if(
    //                 $details['extension'] == 'mp4' ||
    //                 $details['extension'] == 'mkv' ||
    //                 $details['extension'] == 'avi') {

    //                 $dataArray = array(
    //                     'file_no' => $fileNo,
    //                     'name' => $details['name'],
    //                     'extension' => $details['extension'],
    //                     'timestamp' => $details['timestamp'],
    //                     'mimetype' => $details['mimetype'],
    //                     'size' => $details['size'],
    //                     'url' => $url
    //                 );

    //                 $fileDatails[] = (object) $dataArray;
    //             }
    //             $fileNo++;
    //         }

    //     } else {
    //         $fileDatails = null;
    //     }

    //     if(isset($fileDatails)){
    //         $fileDatails = $fileDatails;
    //     } else {
    //         $fileDatails = null;
    //     }

    //     return view('pages.file_management.videos', ['fileDatails'=>$fileDatails]);
    // }

    // public function audio(){
    //     $files = Storage::disk('google')->allFiles();

    //     if($files){
    //         $fileNo = 0;
    //         foreach($files as $file){
    //             $details = Storage::disk('google')->getMetadata($file);

    //             $url = Storage::disk('google')->url($file);

    //             if(
    //                 $details['extension'] == 'mp3' ||
    //                 $details['extension'] == 'wav' ) {

    //                 $dataArray = array(
    //                     'file_no' => $fileNo,
    //                     'name' => $details['name'],
    //                     'extension' => $details['extension'],
    //                     'timestamp' => $details['timestamp'],
    //                     'mimetype' => $details['mimetype'],
    //                     'size' => $details['size'],
    //                     'url' => $url
    //                 );

    //                 $fileDatails[] = (object) $dataArray;
    //             }
    //             $fileNo++;
    //         }

    //     } else {
    //         $fileDatails = null;
    //     }

    //     if(isset($fileDatails)){
    //         $fileDatails = $fileDatails;
    //     } else {
    //         $fileDatails = null;
    //     }

    //     return view('pages.file_management.audio', ['fileDatails'=>$fileDatails]);
    // }

    // public function zipFiles(){
    //     $files = Storage::disk('google')->allFiles();

    //     if($files){
    //         $fileNo = 0;
    //         foreach($files as $file){
    //             $details = Storage::disk('google')->getMetadata($file);

    //             $url = Storage::disk('google')->url($file);

    //             if(
    //                 $details['extension'] == 'zip' ||
    //                 $details['extension'] == '7zip' ||
    //                 $details['extension'] == 'rar' ) {

    //                 $dataArray = array(
    //                     'file_no' => $fileNo,
    //                     'name' => $details['name'],
    //                     'extension' => $details['extension'],
    //                     'timestamp' => $details['timestamp'],
    //                     'mimetype' => $details['mimetype'],
    //                     'size' => $details['size'],
    //                     'url' => $url
    //                 );

    //                 $fileDatails[] = (object) $dataArray;
    //             }
    //             $fileNo++;
    //         }

    //     } else {
    //         $fileDatails = null;
    //     }

    //     if(isset($fileDatails)){
    //         $fileDatails = $fileDatails;
    //     } else {
    //         $fileDatails = null;
    //     }

    //     return view('pages.file_management.zip_files', ['fileDatails'=>$fileDatails]);
    // }

    public function download($fileId){
        $files = Storage::disk('google')->allFiles();
        $fileDetails = $files[$fileId];

        $details = Storage::disk('google')->getMetadata($fileDetails);
        $name = $details['name'];

        $response = Storage::disk('google')->download($fileDetails, $name);
        $response->send();
    }

    public function upload(Request $request){
        $file = $request->file('upload_file');
        $fileName = $file->getClientOriginalName();

        Storage::disk('google')->putFileAs('1RexH3NXRUYLBzYjpmh2HCJml0mM_YiNW', $request->file('upload_file'), $fileName);

        // info.enricharcane@gmail.com
        // Storage::disk('google')->putFileAs('1fm02UnCZF2PZLzQLgqDQez4ADmGrZJXu', $request->file('upload_file'), $fileName);

        return redirect()->back()->withSuccess('File Uploaded Successfully!');
    }

    public function createFolder(Request $request){
        Storage::disk('google')->makeDirectory($request->directoryPath.'/'.$request->folderName);
        return json_encode('Folder Created Successfully!');
    }

    public function renameFolder(Request $request){
        Storage::disk('google')->rename($request->renamedDirectory, $request->directoryPath.'/'.$request->folderName);
        return json_encode('Folder Renamed Successfully!');
    }

    public function createFile(Request $request){
        $file = $request->file('create_file');
        Storage::disk('google')->putFileAs($request->create_file_path, $file, $file->getClientOriginalName());

        return json_encode('File Uploaded Successfully!');
    }

    public function renameFile(Request $request){
        $stor = Storage::disk('google')->rename($request->renameFilePath, $request->createFilePath.'/'.$request->fileName.'.'.$request->fileExtension);
        return json_encode('File Renamed Successfully!');
    }

    public function share(Request $request){
        $shareUserCategory = $request->share_user_category;

        if ($shareUserCategory == 'user_groups') {
            $userRoleId = $request->user_id;

            $userIds =  User::whereHas("roles", function($q) use($userRoleId) {
                                $q->where("id", $userRoleId);
                            })
                            ->whereNotIn('id', [Auth::user()->id])->where('active', 1)->get()->pluck('id');

            foreach ($userIds as $userId) {
                $itemShare = self::shareItem($request, $userId);
            }

            if ($itemShare == true) {
                return json_encode('Item Shared Successfully!');
            } else {
                return json_encode('Something went worng when sharing item');
            }

        } else {
            $userId = $request->user_id;
            $itemShare = self::shareItem($request, $userId);

            if ($itemShare == true) {
                return json_encode('Item Shared Successfully!');
            } else {
                return json_encode('Something went worng when sharing item');
            }
        }
    }

    public function shareItem(Request $request, $userId){
        $userId = $userId;
        $userSharedFolder = UserSharedFolder::where('user_id', $userId)->first();

        $userSharedFolderId = '';
        if ($userSharedFolder) {
            $userSharedFolderId = $userSharedFolder->user_shared_folder_id;

        } else {
            $userSharedFolderId = self::createSharedFolder($userId);
        }

        if ($request->share_type == 2) {
            $details = Storage::disk('google')->getMetadata($request->share_path);
            $itemShare = Storage::disk('google')->copy($request->file_path, $userSharedFolderId.'/'.$details['name']);

            return $itemShare;

        } else {
            $sharingFolder = $request->share_path;

            $folder = Storage::disk('google')->getMetadata($sharingFolder);

            // remove parent folder
            $createNewDitemShareirectory = Storage::disk('google')->makeDirectory($userSharedFolderId.'/'.$folder['name']);
            $newDirectory = Storage::disk('google')->getMetadata($userSharedFolderId.'/'.$folder['name']);

            // reove parent files
            $details = Storage::disk('google')->files($sharingFolder);
            foreach ($details as $detail) {
                $fileDetails = Storage::disk('google')->getMetadata($detail);
                Storage::disk('google')->copy($detail, $newDirectory['path'].'/'.$fileDetails['name']);
            }

            // remove subfolders
            $subDirectories = Storage::disk('google')->directories($sharingFolder);
            if ($subDirectories) {
                self::moveSharedSubDirs($subDirectories, $newDirectory);
            }

            $itemShare = $createNewDitemShareirectory;
            return $itemShare;
        }
    }

    public function rename(Request $request){
        Storage::disk('google')->move('1TNPC359GUXWYJJQwvXU8FgZyV2kp6qeR/1Ks8Q-X_Rnp1v527K9LoM0vTrG2JIfUfc', 'new-test');

        return json_encode('Folder / File Renamed Successfully!');
    }

    public function userGroupFactories(){
        $user = Auth::user();
        $factoryIds = [];
        if($user->hasRole([1, 2, 3, 4, 10])){
            $oderSearch = 'all';
        } else {
            $oderSearch = 'factory';
            foreach($user->roles as $userRole){
                if($userRole->id == 5){     // PBS Factory
                    $factoryIds[] = 2;  // PBS
                }
                if($userRole->id == 6){     // WDC Factory
                    $factoryIds[] = 1;  // WDC
                }
                if($userRole->id == 7){     // BII Factory
                    $factoryIds[] = 3;  // BII
                }
                if($userRole->id == 8){     // UET Factory
                    $factoryIds[] = 7;  // UET
                }
                if($userRole->id == 11){     // ZYS Factory
                    $factoryIds[] = 10;  // ZYS
                }
                if($userRole->id == 12){     // Test Factory
                    $factoryIds[] = 16;  // Test
                }
            }
        }

        $this->oderSearch = $oderSearch;
        $this->factoryIds = $factoryIds;

        return $this;
    }

    public function moveToMyDriveFile(Request $request){
        $details = Storage::disk('google')->getMetadata($request->shared_file_id);
        $stored_file = Storage::disk('google')->copy($request->shared_file_path, $request->selected_my_drive_path.'/'.$details['name']);

        if ($stored_file == true) {
            Storage::disk('google')->delete($request->shared_file_id);
            return json_encode('File Moved to My Drive Successfully!');
        } else {
            return json_encode('Something went worng when moving file to my drive');
        }
    }

    public function moveToMyDriveFolder(Request $request){
        $shareFolder = $request->shared_file_id;
        $selectedPath = $request->selected_my_drive_path;

        $folder = Storage::disk('google')->getMetadata($shareFolder);

        // create parent folder
        $createNewDirectory = Storage::disk('google')->makeDirectory($selectedPath.'/'.$folder['name']);
        $newDirectory = Storage::disk('google')->getMetadata($selectedPath.'/'.$folder['name']);

        // create parent files
        $details = Storage::disk('google')->files($shareFolder);
        foreach ($details as $detail) {
            $fileDetails = Storage::disk('google')->getMetadata($detail);
            Storage::disk('google')->copy($detail, $newDirectory['path'].'/'.$fileDetails['name']);
        }

        // create subfolders
        $subDirectories = Storage::disk('google')->directories($shareFolder);
        if ($subDirectories) {
            self::moveSharedSubDirs($subDirectories, $newDirectory);
        }

        if ($createNewDirectory == true) {
            Storage::disk('google')->deleteDirectory($shareFolder);
            return json_encode('Folder Moved to My Drive Successfully!');
        } else {
            return json_encode('Something went worng when moving folder to my drive');
        }
    }

    public function moveSharedSubDirs($subDirectories, $newDirectory) {
        foreach($subDirectories as $subDirectory){
            $subFolder = Storage::disk('google')->getMetadata($subDirectory);
            Storage::disk('google')->makeDirectory($newDirectory['path'].'/'.$subFolder['name']);
            $newSubDirectory = Storage::disk('google')->getMetadata($newDirectory['path'].'/'.$subFolder['name']);

            $subDirDetails = Storage::disk('google')->files($subDirectory);
            foreach ($subDirDetails as $subDirDetail) {
                $subFileDetails = Storage::disk('google')->getMetadata($subDirDetail);
                Storage::disk('google')->copy($subDirDetail, $newSubDirectory['path'].'/'.$subFileDetails['name']);
            }

            $subSubDirectories = Storage::disk('google')->directories($subDirectory);
            if ($subSubDirectories) {
                self::moveSharedSubDirs($subSubDirectories, $newSubDirectory);
            }
        }
    }

    public function moveToFile(Request $request){
        $details = Storage::disk('google')->getMetadata($request->moving_file);
        $stored_file = Storage::disk('google')->move($request->moving_file_path, $request->selected_drive_path.'/'.$details['name']);

        if ($stored_file == true) {
            return json_encode('File Moved Successfully!');
        } else {
            return json_encode('Something went worng when moving file');
        }
    }

    public function moveToFolder(Request $request){
        $movingFolder = $request->moving_file;
        $selectedPath = $request->selected_drive_path;

        $folder = Storage::disk('google')->getMetadata($movingFolder);

        // create parent folder
        $createNewDirectory = Storage::disk('google')->makeDirectory($selectedPath.'/'.$folder['name']);
        $newDirectory = Storage::disk('google')->getMetadata($selectedPath.'/'.$folder['name']);

        // create parent files
        $details = Storage::disk('google')->files($movingFolder);
        foreach ($details as $detail) {
            $fileDetails = Storage::disk('google')->getMetadata($detail);
            Storage::disk('google')->move($detail, $newDirectory['path'].'/'.$fileDetails['name']);
        }

        // create subfolders
        $subDirectories = Storage::disk('google')->directories($movingFolder);
        if ($subDirectories) {
            self::moveSubDirs($subDirectories, $newDirectory);
        }

        if ($createNewDirectory == true) {
            Storage::disk('google')->deleteDirectory($movingFolder);
            return json_encode('Folder Moved to My Drive Successfully!');
        } else {
            return json_encode('Something went worng when moving folder to my drive');
        }
    }

    public function moveSubDirs($subDirectories, $newDirectory) {
        foreach($subDirectories as $subDirectory){
            $subFolder = Storage::disk('google')->getMetadata($subDirectory);
            Storage::disk('google')->makeDirectory($newDirectory['path'].'/'.$subFolder['name']);
            $newSubDirectory = Storage::disk('google')->getMetadata($newDirectory['path'].'/'.$subFolder['name']);

            $subDirDetails = Storage::disk('google')->files($subDirectory);
            foreach ($subDirDetails as $subDirDetail) {
                $subFileDetails = Storage::disk('google')->getMetadata($subDirDetail);
                Storage::disk('google')->move($subDirDetail, $newSubDirectory['path'].'/'.$subFileDetails['name']);
            }

            $subSubDirectories = Storage::disk('google')->directories($subDirectory);
            if ($subSubDirectories) {
                self::moveSubDirs($subSubDirectories, $newSubDirectory);
            }
        }
    }
}
