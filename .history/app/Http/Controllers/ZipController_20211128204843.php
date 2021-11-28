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
        	$public_dir=public_path();
        	// Zip File Name
            $zipFileName = 'AllDocuments.zip';
            // Create ZipArchive Obj
            $zip = new ZipArchive;
            if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
            	// Add File in ZipArchive
                $zip->addFile('../public/qr_code/','file_name');
                // Close ZipArchive
                if(file_exists($zip_file)){
                    header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
                    header("Content-Type: application/zip");
                    header("Content-Transfer-Encoding: Binary");
                    header("Content-Length: ".filesize($zip_file));
                    header("Content-Disposition: attachment; filename=\"".basename($zip_file)."\"");
                    readfile($zip_file);
                    unlink($zip_file);
                    exit;
                }            }
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
        return view('qr_codes/qr_builder');
    }
}