<?php

namespace App\Http\Controllers\ckyc;

use App\Http\Controllers\ckyc\Controller;
use App\Models\ckycModel;
use Illuminate\Http\Request;
use Log;

class CropImageController extends Controller
{
    /*public function index()
    {
        $imgArray = [];
        $cifno = 12345678900;
        $tdate = date('Y-m-10');
        $cifuser = ckycModel::where('cifnumber',$cifno)->where('cifdate',$tdate)->first();
        if(!empty($cifuser))
        {
            $imgpath = $cifuser->imagePath;
            $imgArray = explode(';',$imgpath);
        }
        $icount = count($imgArray);
        $imageAssets = [];
        foreach($imgArray as $key=>$value)
        {
            $imageAssets[$key] = str_replace('D:\\Server\\data\\htdocs\\ckyc\\public\\','',$imgArray[$key]);
        }
        //return $imageAssets;
        return view('ckyc.usercrop')->with(compact('imgArray','icount','imageAssets','cifno'));
    }*/

    /* Already working solution.
    public function upload(Request $request)
    {
        Log::info($request->cif);
        $cifno = $request->cif;
        $photo_type = $request->type;
        
        $cifuser = ckycModel::where('cifnumber',$cifno)->first();
        if(!empty($cifuser))
        {
            $datefolder = date('Ymd',strtotime($cifuser->cifdate));
            $folderPath = public_path('uploads\\').$datefolder;
            $folderPath = $folderPath.'\\'.$cifno.'\\';
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath .$cifno.'_'.$photo_type . '.jpeg';

            file_put_contents($file, $image_base64);
            //compressing 587 kb file to 80kb.
            //the 80 here denotes the quality.
            $msg = $this->compress_image($file, $file, 90);

            return response()->json(['success'=>$msg]);
        }
        else
        {
            $folderPath = public_path('\\');
            $folderPath = public_path('uploads\\').date('Ymd');
            $folderPath = $folderPath.'\\'.$cifno.'\\';
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath .$cifno.'_'.$photo_type . '.jpeg';

            file_put_contents($file, $image_base64);
            //compressing 587 kb file to 80kb.
            //the 80 here denotes the quality.
            $msg = $this->compress_image($file, $file, 90);

            return response()->json(['success'=>$msg]);
        }        
    }*/

    //Edited this on 2021-06-11 for discrepancy in cif number
    public function upload(Request $request)
    {
        Log::info($request->cif);
        $cifno = $request->cif;
        $photo_type = $request->type;
        $tdate = date('Y-m-d');
        $cifuser = ckycModel::where('cifnumber',$cifno)->where('cifdate',$tdate)->first();
        Log::info($cifuser);
        if(!empty($cifuser))
        {
            $datefolder = date('Ymd',strtotime($cifuser->cifdate));
            $folderPath = public_path('uploads\\').$datefolder;
            $folderPath = $folderPath.'\\'.$cifno.'\\';
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath .$cifno.'_'.$photo_type . '.jpeg';

            file_put_contents($file, $image_base64);
            //compressing 587 kb file to 80kb.
            //the 80 here denotes the quality.
            $msg = $this->compress_image($file, $file, 90);

            return response()->json(['success'=>$msg]);
        }
        else
        {
            $folderPath = public_path('\\');
            $folderPath = public_path('uploads\\').date('Ymd');
            $folderPath = $folderPath.'\\'.$cifno.'\\';
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath .$cifno.'_'.$photo_type . '.jpeg';

            file_put_contents($file, $image_base64);
            //compressing 587 kb file to 80kb.
            //the 80 here denotes the quality.
            $msg = $this->compress_image($file, $file, 90);

            return response()->json(['success'=>$msg]);
        }        
    }

    function compress_image($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        //uncomment the below code torun compression
        imagejpeg($image, $destination_url, $quality);
        return $message = "Image uploaded successfully";
        Log::info("Image uploaded successfully.");
    }

    function fsubmit(Request $request)
    {
        $cno = $request->input('cifno');
        return redirect()->route('home')->with('success','CIF number '.$cno.' is successfully saved');
    }
}
