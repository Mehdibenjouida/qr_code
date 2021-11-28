<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use ZipArchive;
use Illuminate\Support\Carbon;

class ZipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadZip(Request $request)
    {

        if($request->has('download')) {
        	// Define Dir Folder
        	$public_dir=public_path('../public/qr_code/');
        	// Zip File Name
            $zipFileName = 'AllDocuments.zip';
            // Create ZipArchive Obj
            $zip = new ZipArchive;
            if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
            	// Add File in ZipArchive
                $zip->addFile(file_path,'file_name');
                // Close ZipArchive
                $zip->close();
            }
            // Set Header
            $headers = array(
                'Content-Type' => 'application/octet-stream',
            );
            $filetopath=$public_dir.'/'.$zipFileName;
            // Create Download Response
            if(file_exists($filetopath)){
                return response()->download($filetopath,$zipFileName,$headers);
            }
        }
        return view('createZip');
    }
}
