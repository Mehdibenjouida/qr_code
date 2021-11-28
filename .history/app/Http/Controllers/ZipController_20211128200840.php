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
    public function downloadZip()
    {

         $public_dir=public_path().'../storage/qr_code/';
        $zipFileName = Carbon\Carbon::now().'.zip';
        $zip = new ZipArchive;
        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
            $zip->addFile('file_path','file_name');
             $zip->close();
        }
         $headers = array(
                'Content-Type' => 'application/octet-stream',
            );
        $filetopath=$public_dir.'/'.$zipFileName;
        if(file_exists($filetopath)){
            return response()->download($filetopath,$zipFileName,$headers);
        }
        return ['status'=>'file does not exist'];
}
}
