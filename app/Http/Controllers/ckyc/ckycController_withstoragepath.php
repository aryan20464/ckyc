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
        return view('ckyc.userhome');
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
            $folderPath = storage_path('app\\public\\uploads\\');
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

    public function storeImage(Request $request)
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
                return back()->with('message','CIF is already present');
            }            
            $folderPath = storage_path('app\\public\\uploads\\').date('Ymd');
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
            $fileName = $customer_cif.'_photo.png';    
            $file = $folderPath . $fileName;
            $file1 = $folderPath . $customer_cif.'_photo_opti.png';
            $stringPath = $stringPath.$file.';';
            $stringNames = $stringNames.$fileName.';';
            file_put_contents($file, $image_base64); 
           //use the below line if you want both the files original and optimised to appear in folder.
            //$this->compress_image($file, $file1, 80);
            //the below line will overwrite the original file with optimised one.
            $this->compress_image($file, $file, 80);
            /*ImageOptimizer::optimize($file, $file1);
            $this->convert($file1, $file1);
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize(storage_path('origfile.jpg'));
            ImageOptimizer::optimize(storage_path('origfile.jpg'), $file1);
            $this->convert($file1, $file1);*/
            //$filename = $this->compress_image($file, $file1, 80);
            
            
            //idproof
            $image_parts = explode(";base64,", $img2);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];    
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $customer_cif.'_idproof.png';     
            $file = $folderPath . $fileName;    
            $file1 = $folderPath . $customer_cif.'_idproof_opti.png';
            $stringPath = $stringPath.$file.';';    
            $stringNames = $stringNames.$fileName.';';
            file_put_contents($file, $image_base64); 
            //use the below line if you want both the files original and optimised to appear in folder.
            //$this->compress_image($file, $file1, 80);
            //the below line will overwrite the original file with optimised one.
            $this->compress_image($file, $file, 80);
            
            //addressproof
            $image_parts = explode(";base64,", $img3);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $customer_cif.'_addr_proof.png';     
            $file = $folderPath . $fileName;
            $file1 = $folderPath . $customer_cif.'_addr_proof_opti.png';
            $stringPath = $stringPath.$file;
            $stringNames = $stringNames.$fileName.';';
            file_put_contents($file, $image_base64); 
            //use the below line if you want both the files original and optimised to appear in folder.
            //$this->compress_image($file, $file1, 80);
            //the below line will overwrite the original file with optimised one.
            $this->compress_image($file, $file, 80);
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
    }

    // this function is currenty used to compress the image files.
    function compress_image($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        imagejpeg($image, $destination_url, $quality);
        Log::info("Image uploaded successfully.");
    }

    public function showUploadedCIFS()
    {
        $userpresent = ckycModel::all();
        $userdates = ckycModel::distinct()->pluck('cifdate');
        $usercount = DB::connection('mysql')->table('ckycdetails')->select(DB::raw('count(*) as cif_count, cifdate'))->groupBy('cifdate')->get();
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
                //unlink(storage_path($zipFileName));
                if(file_exists(storage_path($zipFileName)))
                {
                    //return "iam in fileexists";
                    File::delete(storage_path($zipFileName));
                    //return "iam in after filedelete";
                }
                if($zip->open(storage_path($zipFileName), ZipArchive::CREATE) === TRUE) 
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
                    //return storage_path($zipFileName);
                }     

                $pathToFile = storage_path($zipFileName);
                if(file_exists($pathToFile))
                {                                   
                    return response()->download(storage_path($zipFileName));
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
        $the_folder = storage_path('app\\public\\uploads\\').$ddate;
        $zip_file_name = storage_path('zip_').$ddate.'.zip';
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
        $ckycinfo = ckycModel::where('cifnumber',$cifno)->get();
        if(count($ckycinfo)>0)
        {
            $message = 1;
            return response()->json(['status'=>$message]);
        }
        else
        {
            $message = 0;
            return response()->json(['status'=>$message]);
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




