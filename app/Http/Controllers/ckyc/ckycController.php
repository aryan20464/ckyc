<?php

namespace App\Http\Controllers\ckyc;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\ckycModel;
use ZipArchive;
use ImageOptimizer;
use Log;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ckycController extends Controller
{
    //
    public function displayHomePage()
    {
        $tdate = date('y-m-d');
        $udetails = ckycModel::where('cifdate',$tdate)->orderBy('created_at','DESC')->get();
        $ncount = count($udetails)+1; // here the number corresponds to the cifnumber that is to be processed currently.
        return view('ckyc.userhome')->with(compact('ncount'));
    }

    public function displayIndex()
    {
        return view('ckyc.index');
    }

    /*public function storeImage(Request $request)
    {
       try 
       {
            $customer_cif = $request->input('customer_cif');
            //return strlen($customer_cif);
            $img = $request->input('image');
            $img2 = $request->input('image2');
            $img3 = $request->input('image3');
            $userpresent = ckycModel::where('cifnumber',$customer_cif)->get();
            if(count($userpresent)>0)
            {
                return back()->with('message','CIF is already present')->withInput($customer_cif);
            }
            $folderPath = public_path('uploads\\');
            $folderPath = $folderPath.$customer_cif.'\\';
            File::makeDirectory($folderPath, $mode = 0777, true, true);
            $stringPath = '';
            $stringNames = '';

            //customer_image
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];    
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $customer_cif.'_photo.png';    
            $file = $folderPath . $fileName;
            $stringPath = $stringPath.$file.';';
            $stringNames = $stringNames.$fileName.';';
            file_put_contents($file, $image_base64); 
            
            //idproof
            $image_parts = explode(";base64,", $img2);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];    
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $customer_cif.'_idproof.png';     
            $file = $folderPath . $fileName;    
            $stringPath = $stringPath.$file.';';    
            $stringNames = $stringNames.$fileName.';';
            file_put_contents($file, $image_base64); 
            
            //addressproof
            $image_parts = explode(";base64,", $img3);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $customer_cif.'_addr_proof.png';     
            $file = $folderPath . $fileName;
            $stringPath = $stringPath.$file;
            $stringNames = $stringNames.$fileName.';';
            file_put_contents($file, $image_base64); 
            //return $stringPath;

            $ckyc = new ckycModel;
            $ckyc->cifnumber = $customer_cif;
            $ckyc->imagePath = $stringPath;
            $ckyc->imageNames = $stringNames;
            $ckyc->cifdate = date('Y-m-d');
            $sucflag = $ckyc->save();
            if($sucflag)
            {
                return back()->with('success','Customer with CIF => '.$customer_cif.' is successfully captured');
            }
       } 
       catch (\Exception $e) 
       {
        return back()->with('failure','Capturing Customer with CIF => '.$customer_cif.' is Unsuccessful '.$e->getMessage());
       }
    }*/

    /*public function storeImage(Request $request)
    {
       try 
       {
            $customer_cif = $request->input('customer_cif');
            $cifno = $customer_cif;
            $userpresent = ckycModel::where('cifnumber',$customer_cif)->get();
            if(count($userpresent)>0)
            {
                
                $stringPath = '';
                $stringNames = '';
                $img = $request->input('image');
                $img2 = $request->input('image2');
                $img3 = $request->input('image3');

                $datefolder = date('Ymd',strtotime($userpresent[0]->cifdate));
                $folderPath = public_path('uploads\\').$datefolder;
                $folderPath = $folderPath.'\\'.$customer_cif.'\\';
                $image_parts = explode(";base64,", $img);
                if(count($image_parts)>=2)
                {
                    $image_type_aux = explode("image/", $image_parts[0]);                
                    $image_type = $image_type_aux[1];    
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = $customer_cif.'_photo.jpeg';    
                    $file = $folderPath . $fileName;
                    $file1 = $folderPath . $customer_cif.'_photo_opti.jpeg';
                    $stringPath = $stringPath.$file.';';
                    $stringNames = $stringNames.$fileName.';';
                    file_put_contents($file, $image_base64); 
                    $this->compress_image($file, $file, 80);    
                }
                        
                
                //idproof
                $image_parts = explode(";base64,", $img2);
                if(count($image_parts)>=2)
                {
                    $image_type_aux = explode("image/", $image_parts[0]);                
                    $image_type = $image_type_aux[1];    
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = $customer_cif.'_idproof.jpeg';     
                    $file = $folderPath . $fileName;    
                    $file1 = $folderPath . $customer_cif.'_idproof_opti.jpeg';
                    $stringPath = $stringPath.$file.';';    
                    $stringNames = $stringNames.$fileName.';';
                    file_put_contents($file, $image_base64); 
                    $this->compress_image($file, $file, 80);
                }
                
                //addressproof
                $image_parts = explode(";base64,", $img3);
                if(count($image_parts)>=2)
                {
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = $customer_cif.'_addr_proof.jpeg';     
                    $file = $folderPath . $fileName;
                    $file1 = $folderPath . $customer_cif.'_addr_proof_opti.jpeg';
                    $stringPath = $stringPath.$file;
                    $stringNames = $stringNames.$fileName.';';
                    file_put_contents($file, $image_base64); 
                    $this->compress_image($file, $file, 80);
                }
                
                $imgpath = $userpresent[0]->imagePath;
                $imgArray = explode(';',$imgpath);
                $icount = count($imgArray);
                $imageAssets = [];
                foreach($imgArray as $key=>$value)
                {
                    $imageAssets[$key] = str_replace('D:\\Server\\data\\htdocs\\ckyc\\public\\','',$imgArray[$key]);
                }
                $uploaded = $datefolder;
                return view('ckyc.usercrop')->with(compact('imgArray','icount','imageAssets','cifno','uploaded'));
            }
            else
            {
                $img = $request->input('image');
                $img2 = $request->input('image2');
                $img3 = $request->input('image3');
                $folderPath = public_path('uploads\\').date('Ymd');
                $folderPath = $folderPath.'\\'.$customer_cif.'\\';
                //return $folderPath;
                File::makeDirectory($folderPath, $mode = 0777, true, true);
                $stringPath = '';
                $stringNames = '';

                //customer_image
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];    
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = $customer_cif.'_photo.jpeg';    
                $file = $folderPath . $fileName;
                $file1 = $folderPath . $customer_cif.'_photo_opti.jpeg';
                $stringPath = $stringPath.$file.';';
                $stringNames = $stringNames.$fileName.';';
                file_put_contents($file, $image_base64); 
                $this->compress_image($file, $file, 100);            
                
                //idproof
                $image_parts = explode(";base64,", $img2);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];    
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = $customer_cif.'_idproof.jpeg';     
                $file = $folderPath . $fileName;    
                $file1 = $folderPath . $customer_cif.'_idproof_opti.jpeg';
                $stringPath = $stringPath.$file.';';    
                $stringNames = $stringNames.$fileName.';';
                file_put_contents($file, $image_base64); 
                $this->compress_image($file, $file, 80);
                
                //addressproof
                $image_parts = explode(";base64,", $img3);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = $customer_cif.'_addr_proof.jpeg';     
                $file = $folderPath . $fileName;
                $file1 = $folderPath . $customer_cif.'_addr_proof_opti.jpeg';
                $stringPath = $stringPath.$file;
                $stringNames = $stringNames.$fileName.';';
                file_put_contents($file, $image_base64); 
                $this->compress_image($file, $file, 80);

                $ckyc = new ckycModel;
                $ckyc->cifnumber = $customer_cif;
                $ckyc->imagePath = $stringPath;
                $ckyc->imageNames = $stringNames;
                $ckyc->cifdate = date('Y-m-d');
                $sucflag = $ckyc->save();
                //return $sucflag;
                //$this->cropImageInit();
                if($sucflag)
                {
                    $cifno = $customer_cif;
                    $imgArray = [];
                    $cifuser = ckycModel::where('cifnumber',$cifno)->first();
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
                    Log::info('Iam above return');
                    $uploaded = 0;
                    return view('ckyc.usercrop')->with(compact('imgArray','icount','imageAssets','cifno','uploaded'));
                    //return back()->with('success','Customer with CIF => '.$customer_cif.' is successfully captured');
                }
            }
            
       } 
       catch (Exception $e) 
       {
        return back()->with('failure','Capturing Customer with CIF => '.$customer_cif.' is Unsuccessful '.$e->getMessage())->withInput('customer_cif');
       }
    }*/


    //This is edited on 2021-06-11
    public function storeImage(Request $request)
    {
       try 
       {
            $customer_cif = $request->input('customer_cif');
            $cifno = $customer_cif;
            $tdate = date('y-m-d');
            $userpresent = ckycModel::where('cifnumber',$customer_cif)->where('cifdate',$tdate)->get();
            if(count($userpresent)>0)
            {
                
                $stringPath = '';
                $stringNames = '';
                $img = $request->input('image');
                $img2 = $request->input('image2');
                $img3 = $request->input('image3');

                $datefolder = date('Ymd',strtotime($userpresent[0]->cifdate));
                $folderPath = public_path('uploads\\').$datefolder;
                $folderPath = $folderPath.'\\'.$customer_cif.'\\';
                $image_parts = explode(";base64,", $img);
                if(count($image_parts)>=2)
                {
                    $image_type_aux = explode("image/", $image_parts[0]);                
                    $image_type = $image_type_aux[1];    
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = $customer_cif.'_photo.jpeg';    
                    $file = $folderPath . $fileName;
                    $file1 = $folderPath . $customer_cif.'_photo_opti.jpeg';
                    $stringPath = $stringPath.$file.';';
                    $stringNames = $stringNames.$fileName.';';
                    file_put_contents($file, $image_base64); 
                    $this->compress_image($file, $file, 80);    
                }
                        
                
                //idproof
                $image_parts = explode(";base64,", $img2);
                if(count($image_parts)>=2)
                {
                    $image_type_aux = explode("image/", $image_parts[0]);                
                    $image_type = $image_type_aux[1];    
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = $customer_cif.'_idproof.jpeg';     
                    $file = $folderPath . $fileName;    
                    $file1 = $folderPath . $customer_cif.'_idproof_opti.jpeg';
                    $stringPath = $stringPath.$file.';';    
                    $stringNames = $stringNames.$fileName.';';
                    file_put_contents($file, $image_base64); 
                    $this->compress_image($file, $file, 80);
                }
                
                //addressproof
                $image_parts = explode(";base64,", $img3);
                if(count($image_parts)>=2)
                {
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = $customer_cif.'_addr_proof.jpeg';     
                    $file = $folderPath . $fileName;
                    $file1 = $folderPath . $customer_cif.'_addr_proof_opti.jpeg';
                    $stringPath = $stringPath.$file;
                    $stringNames = $stringNames.$fileName.';';
                    file_put_contents($file, $image_base64); 
                    $this->compress_image($file, $file, 80);
                }
                
                $imgpath = $userpresent[0]->imagePath;
                $imgArray = explode(';',$imgpath);
                $icount = count($imgArray);
                $imageAssets = [];
                foreach($imgArray as $key=>$value)
                {
                    $imageAssets[$key] = str_replace('D:\\Server\\data\\htdocs\\ckyc\\public\\','',$imgArray[$key]);
                }
                $uploaded = $datefolder;
                return view('ckyc.usercrop')->with(compact('imgArray','icount','imageAssets','cifno','uploaded'));
            }
            else
            {
                $img = $request->input('image');
                $img2 = $request->input('image2');
                $img3 = $request->input('image3');
                $folderPath = public_path('uploads\\').date('Ymd');
                $folderPath = $folderPath.'\\'.$customer_cif.'\\';
                //return $folderPath;
                File::makeDirectory($folderPath, $mode = 0777, true, true);
                $stringPath = '';
                $stringNames = '';

                //customer_image
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];    
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = $customer_cif.'_photo.jpeg';    
                $file = $folderPath . $fileName;
                $file1 = $folderPath . $customer_cif.'_photo_opti.jpeg';
                $stringPath = $stringPath.$file.';';
                $stringNames = $stringNames.$fileName.';';
                file_put_contents($file, $image_base64); 
                $this->compress_image($file, $file, 100);            
                
                //idproof
                $image_parts = explode(";base64,", $img2);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];    
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = $customer_cif.'_idproof.jpeg';     
                $file = $folderPath . $fileName;    
                $file1 = $folderPath . $customer_cif.'_idproof_opti.jpeg';
                $stringPath = $stringPath.$file.';';    
                $stringNames = $stringNames.$fileName.';';
                file_put_contents($file, $image_base64); 
                $this->compress_image($file, $file, 80);
                
                //addressproof
                $image_parts = explode(";base64,", $img3);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = $customer_cif.'_addr_proof.jpeg';     
                $file = $folderPath . $fileName;
                $file1 = $folderPath . $customer_cif.'_addr_proof_opti.jpeg';
                $stringPath = $stringPath.$file;
                $stringNames = $stringNames.$fileName.';';
                file_put_contents($file, $image_base64); 
                $this->compress_image($file, $file, 80);

                $ckyc = new ckycModel;
                $ckyc->cifnumber = $customer_cif;
                $ckyc->imagePath = $stringPath;
                $ckyc->imageNames = $stringNames;
                $ckyc->cifdate = date('y-m-d');;
                $sucflag = $ckyc->save();
                //return $sucflag;
                //$this->cropImageInit();
                if($sucflag)
                {
                    $cifno = $customer_cif;
                    $imgArray = [];
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
                    Log::info('Iam above return');
                    $uploaded = 0;
                    return view('ckyc.usercrop')->with(compact('imgArray','icount','imageAssets','cifno','uploaded'));
                    //return back()->with('success','Customer with CIF => '.$customer_cif.' is successfully captured');
                }
            }
            
       } 
       catch (Exception $e) 
       {
        return back()->with('failure','Capturing Customer with CIF => '.$customer_cif.' is Unsuccessful '.$e->getMessage())->withInput('customer_cif');
       }
    }

    function cropImageInit($cifno)
    {
        Log::info("iam in cropimageinit");
        $imgArray = [];
        $cifuser = ckycModel::where('cifnumber',$cifno)->first();
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
        Log::info('Iam above return');
        return view('ckyc.usercrop')->with(compact('imgArray','icount','imageAssets','cifno'));
    }

    // this function is currenty used to compress the image files. // original without left flip
    /*function compress_image($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        imagejpeg($image, $destination_url, $quality);
        
        Log::info("Image uploaded successfully.");
    }*/

    // this function is currenty used to compress the image files. // with left flip -- if this function is used remove the rotate logic in userhome.blade.php javascript functions take_snapshots
    function compress_image($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        $image = imagerotate($image, 90, 0);
        imagejpeg($image, $destination_url, $quality);
        
        Log::info("Image uploaded successfully.");
    }

    public function showUploadedCIFS()
    {
        $userpresent = ckycModel::all();
        $userdates = ckycModel::distinct()->pluck('cifdate');
        $usercount = DB::connection('mysql')->table('ckycdetails')->select(DB::raw('count(*) as cif_count, cifdate'))->groupBy('cifdate')->get();
        $ucount = [];
        foreach($usercount as $key=>$value)
        {
            $ucount[$usercount[$key]->cifdate] = $usercount[$key]->cif_count;
        }
        return view('ckyc.uploadedcifs')->with(compact('userpresent','userdates','usercount','ucount'));
    }

    public function downloadFile($id)
    {
        try
        {
            $userpresent = ckycModel::where('id',$id)->first();
            $zipFileName = $userpresent->cifnumber.'.zip';
            //$zipFileName = 'czxd'.'.zip';
            $zip = new ZipArchive;
            $fileurl = $userpresent->imagePath;
            $filenames = $userpresent->imageNames;
            $files_req = explode(';',$fileurl);
            $files_names = explode(';',$filenames);
            //return $files_names;
            if(count($files_names)>1)
            {
                //unlink(public_path($zipFileName));
                if(file_exists(public_path($zipFileName)))
                {
                    //return "iam in fileexists";
                    File::delete(public_path($zipFileName));
                    //return "iam in after filedelete";
                }
                if($zip->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE) 
                { 
                    
                    foreach($files_req as $key=>$value)
                    {
                        if(strlen($files_req[$key])>0)
                        {
                            //return $files_req[$key];
                            $zip->addFile($files_req[$key],$files_names[$key]);
                        }                        
                    }
                    $zip->close();
                    //return public_path($zipFileName);
                }     

                $pathToFile = public_path($zipFileName);
                if(file_exists($pathToFile))
                {                                   
                    return response()->download(public_path($zipFileName));
                }
                else
                {
                    return back()->with('failure','File Not Found');
                }
            }
        }
        catch(\Exception $e)
        {
            return back()->with('failure','Download Failed '.$e->getMessage());
        }
    }

    public function downloadFile2($ddate)
    {
        $ddate = date('Ymd',strtotime($ddate));
        $the_folder = public_path('uploads\\').$ddate;
        $zip_file_name = public_path('zip_').$ddate.'.zip';
        //return $zip_file_name;
        if(file_exists($zip_file_name))
        {
            File::delete($zip_file_name);
            //return "iam in after filedelete";
        }
        $za = new FlxZipArchive;
        $res = $za->open($zip_file_name, ZipArchive::CREATE);
        if($res === TRUE) 
        {
            $za->addDir($the_folder, basename($the_folder));
            $za->close();
        }
        else{
        echo 'Could not create a zip archive';
        }
        return response()->download($zip_file_name);
    }

    public function getcifno($cifno)
    {
        Log::info($cifno);
        $ckycinfo = ckycModel::where('cifdate',date('Y-m-d'))->where('cifnumber',$cifno)->get();
        Log::info($ckycinfo);
        if(count($ckycinfo)>0)
        {
            $message = 1;
            $ckycinfo['message'] = 1;
            $imgpath = $ckycinfo[0]->imagePath;
            $imgArray = explode(';',$imgpath);
            $icount = count($imgArray);
            $imageAssets = [];
            foreach($imgArray as $key=>$value)
            {
                $imageAssets[$key] = str_replace('D:\\Server\\data\\htdocs\\ckyc\\public\\','',$imgArray[$key]);
                $imageAssets[$key] = str_replace('\\','/',$imageAssets[$key]);
            }
            $ckycinfo['img1'] = $imageAssets[0];
            $ckycinfo['img2'] = $imageAssets[1];
            $ckycinfo['img3'] = $imageAssets[2];
            return response()->json(['status'=>$ckycinfo]);
        }
        else
        {
            $message = 0;
            $ckycinfo['message'] = 0;
            return response()->json(['status'=>$ckycinfo]);
        }
    }

    /*public function addDir($location, $name) 
    {
        $this->addEmptyDir($name);
        $this->addDirDo($location, $name);
    } 
    private function addDirDo($location, $name) 
    {
        $name .= '/';
        $location .= '/';
        $dir = opendir ($location);
        while ($file = readdir($dir))
        {
            if ($file == '.' || $file == '..') continue;
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } */

    public function convert($from, $to)
    {
        $command = 'convert '
            . $from
            .' '
            . '-sampling-factor 4:2:0 -strip -quality 65'
            .' '
            . $to;
        return $command;
    }

    function cropimage()
    {
     return view('ckyc.image_crop');
    }

    public function uploadCropImage(Request $request)
    {
        $image = $request->image;

        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);
        $image_name= time().'.png';
        $path = public_path('upload/'.$image_name);

        file_put_contents($path, $image);
        return response()->json(['status'=>true]);
    }

}

class FlxZipArchive extends ZipArchive 
{
    public function addDir($location, $name) 
    {
        $this->addEmptyDir($name);
        $this->addDirDo($location, $name);
    } 
    private function addDirDo($location, $name) 
    {
        $name .= '/';
        $location .= '/';
        $dir = opendir ($location);
        while ($file = readdir($dir))
        {
            if ($file == '.' || $file == '..') continue;
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } 
}




