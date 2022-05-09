<?php

namespace App\Http\Controllers\ckyc;

use ZipArchive;
use File;
use Log;
use Session;
use Illuminate\Http\Request;
use App\Models\{EmployeeMaster,EmployeeWorks,BranchMaster};

class AppController extends Controller
{

    public function show_user_data()
    {
        //$bcode = Config('bcode');
        $emps = EmployeeMaster::pluck('name','emp_id')->toArray();
        $branches = BranchMaster::pluck('BRANCHNAME','bcode')->toArray();
        $emp = Session::get('employee_id');
        $username='6160';
        $password='Apgb$123';
        //if(Config('Admin')=='Yes')
        {
            
            $query = 'SELECT CIF_No, updated_at, UploadStatus_1,emp_id,bcode 
            FROM ckyc_temp where UploadStatus_1=1';
        }
        /*else{
            
            $query = 'SELECT CIF_No, updated_at, UploadStatus_1 ,emp_id,bcode 
            FROM ckyc_temp where UploadStatus_1=1 and emp_id ='.$emp;
        }*/
        
        //return $query.Session::get('employee_id');
        $post = [
            'query' => $query,
        ];
        $ch = curl_init('http://3.111.14.201/ckyc/api/get_data');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_PROXY, "10.64.1.189"); //your proxy url
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_PROXYPORT, "3128");
        $response = curl_exec($ch);
        curl_close($ch);
		
       $rows=  json_decode($response) ;


        $var_string='';
        if($rows!=NULL)
        {
            if(sizeof($rows)>0)
            {
                foreach($rows as $key=>$value)
                {
                    $var_string = $var_string.$rows[$key]->CIF_No.',';
                }

                $var_string = rtrim($var_string, ", ");
            }            
        }        
        return view('ckycapp.fileview')->with(compact('rows','var_string','emps','branches'));
    }

    public function emp_summary1(Request $request)
    {
        $emps = EmployeeMaster::pluck('name','emp_id')->toArray();
        $branches = BranchMaster::pluck('BRANCHNAME','bcode')->toArray();
        $emp = Session::get('employee_id');
        $username='6160';
        $password='Apgb$123';
        $empbcodes = EmployeeWorks::pluck('office_code','emp_id')->toArray();
        if($request->isMethod('get'))
        {
            $query2 = "select max(DATE_FORMAT(updated_at, '%Y-%m-%d')) as mdate from ckyc_temp";
            
            //return $query.Session::get('employee_id');
            $post = [
                'query' => $query2,
            ];
            $ch2 = curl_init('http://3.111.14.201/ckyc/api/get_date');
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch2, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch2, CURLOPT_PROXY, "10.64.1.189"); //your proxy url
            curl_setopt($ch2, CURLOPT_PROXYUSERPWD, "$username:$password");
            curl_setopt($ch2, CURLOPT_PROXYPORT, "3128");
            $response2 = curl_exec($ch2);
            curl_close($ch2);
            $rows2=json_decode($response2);
			//return $rows2;
            $datereq = $rows2[0]->mdate;     

            $query1 = "SELECT count(*) as naccounts FROM ckyc_temp where UploadStatus_1=1 and date_format(updated_at,'%Y-%m-%d')>='2022-01-16'";   
        
            //return $query1;
            //return $query.Session::get('employee_id');
            $post = [
                'date' => $datereq,
            ];
            $ch1 = curl_init('http://3.111.14.201/ckyc/api/summary');
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch1, CURLOPT_PROXY, "10.64.1.189"); //your proxy url
            curl_setopt($ch1, CURLOPT_PROXYUSERPWD, "$username:$password");
            curl_setopt($ch1, CURLOPT_PROXYPORT, "3128");
            $response1 = curl_exec($ch1);
            curl_close($ch1);
            $rows1=json_decode($response1);
            $emparray = [];
            foreach($rows1 as $key=>$value)
            {
                $emparray[$rows1[$key]->emp_id]['empid'] = $rows1[$key]->emp_id;
                $emparray[$rows1[$key]->emp_id]['naccounts'] = $rows1[$key]->naccounts;
                $emparray[$rows1[$key]->emp_id]['logintime'] = $rows1[$key]->logintime;
                $emparray[$rows1[$key]->emp_id]['logouttime'] = $rows1[$key]->logouttime;
                $emparray[$rows1[$key]->emp_id]['timediff'] = round((strtotime($rows1[$key]->logouttime) - strtotime($rows1[$key]->logintime))/3600,1);
                if($emparray[$rows1[$key]->emp_id]['timediff']==0)
                {
                    $emparray[$rows1[$key]->emp_id]['avgaccounts'] = $rows1[$key]->naccounts;
                }
                else{
                    $emparray[$rows1[$key]->emp_id]['avgaccounts'] = ceil($rows1[$key]->naccounts / $emparray[$rows1[$key]->emp_id]['timediff']);
                }                                
            }  
			//return $rows1;
            /*if(Session::get('employee_id')==6160)
            {return $emparray;}*/
            return view('ckycapp.empsummary')->with(compact('emps','branches','rows1','emparray','empbcodes','datereq'));
        }   
    }

    public function testsummary(Request $request)
    {
        $emps = EmployeeMaster::pluck('name','emp_id')->toArray();
        $branches = BranchMaster::pluck('BRANCHNAME','bcode')->toArray();
        $emp = Session::get('employee_id');
        $username='6160';
        $password='Apgb$123';
        $empbcodes = EmployeeWorks::pluck('office_code','emp_id')->toArray();
        $regions = BranchMaster::pluck('RO','bcode')->toArray();
        
            $post = [
                'acc_number' => $datereq,
            ];
            $ch1 = curl_init('http://3.111.14.201/ckyc/get_lcpc');
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch1, CURLOPT_PROXY, "10.64.1.189"); //your proxy url
            curl_setopt($ch1, CURLOPT_PROXYUSERPWD, "$username:$password");
            curl_setopt($ch1, CURLOPT_PROXYPORT, "3128");
            $response1 = curl_exec($ch1);
            curl_close($ch1);
            $rows1=json_decode($response1);
            return $rows1;
        

    }

    public function emp_summary(Request $request)
    {
        $emps = EmployeeMaster::pluck('name','emp_id')->toArray();
        $branches = BranchMaster::pluck('BRANCHNAME','bcode')->toArray();
        $emp = Session::get('employee_id');
        $username='6160';
        $password='Apgb$123';
        $empbcodes = EmployeeWorks::pluck('office_code','emp_id')->toArray();
        $regions = BranchMaster::pluck('RO','bcode')->toArray();
        //$onlyreg = BranchMaster::pluck('RO');
        $onlyreg = array('Srikakulam'=>0,
        'Parvathipuram'=>0,
        'Vizianagaram'=>0,
        'Visakhapatnam'=>0,
        'Anakapalli'=>0,
        'Khammam'=>0,
        'Bhadrachalam'=>0,
        'Warangal'=>0,
        'Bhongir'=>0,
        'Siddipet'=>0,
        'Nalgonda'=>0,
        'Nagarkurnool'=>0,
        'Mahabubnagar'=>0,
        'Sangareddy'=>0,
        'LCPC Vizianagaram'=>0,
        'LCPC Nalgonda'=>0
        );
        

        
        if($request->isMethod('get'))
        {
            /*$query2 = "select max(DATE_FORMAT(updated_at, '%Y-%m-%d')) as mdate from ckyc_temp";
            
            //return $query.Session::get('employee_id');
            $post = [
                'query' => $query2,
            ];
            $ch2 = curl_init('http://3.111.14.201/ckyc/api/get_date');
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch2, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch2, CURLOPT_PROXY, "10.64.1.189"); //your proxy url
            curl_setopt($ch2, CURLOPT_PROXYUSERPWD, "$username:$password");
            curl_setopt($ch2, CURLOPT_PROXYPORT, "3128");
            $response2 = curl_exec($ch2);
            curl_close($ch2);
            $rows2=json_decode($response2);
            
           
			//return $rows2;
            $datereq = $rows2[0]->mdate;    */

            $datereq = date('Y-m-d');
            
            $sttime = now();

            $query1 = "SELECT emp_id, count(*) as naccounts ,min(updated_at) as logintime, max(updated_at) as logouttime FROM ckyc_temp where UploadStatus_1=1 and date_format(updated_at,'%Y-%m-%d') = '".$datereq."' group by emp_id order by naccounts DESC";   

            
        
            //return $query1;
            //return $query.Session::get('employee_id');
            $post = [
                'date' => $datereq,
            ];
            $ch1 = curl_init('http://3.111.14.201/ckyc/api/summary');
            //$ch1 = curl_init('http://3.111.14.201/ckyc/api/testsummary');
        
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch1, CURLOPT_PROXY, "10.64.1.189"); //your proxy url
            curl_setopt($ch1, CURLOPT_PROXYUSERPWD, "$username:$password");
            curl_setopt($ch1, CURLOPT_PROXYPORT, "3128");
            $response1 = curl_exec($ch1);
            curl_close($ch1);
            $rows1=json_decode($response1);
            $emparray = [];
            //return $rows1;
            $entime = now();
           
            foreach($rows1 as $key=>$value)
            {
                $emparray[$rows1[$key]->emp_id]['empid'] = $rows1[$key]->emp_id;
                $emparray[$rows1[$key]->emp_id]['naccounts'] = $rows1[$key]->naccounts;
                $emparray[$rows1[$key]->emp_id]['logintime'] = $rows1[$key]->logintime;
                $emparray[$rows1[$key]->emp_id]['logouttime'] = $rows1[$key]->logouttime;
                $emparray[$rows1[$key]->emp_id]['timediff'] = round((strtotime($rows1[$key]->logouttime) - strtotime($rows1[$key]->logintime))/3600,1);
                if($emparray[$rows1[$key]->emp_id]['timediff']==0)
                {
                    $emparray[$rows1[$key]->emp_id]['avgaccounts'] = $rows1[$key]->naccounts;
                }
                else{
                    $emparray[$rows1[$key]->emp_id]['avgaccounts'] = ceil($rows1[$key]->naccounts / $emparray[$rows1[$key]->emp_id]['timediff']);
                }    
                
                
                $onlyreg[$regions[$empbcodes[$rows1[$key]->emp_id]]] += $rows1[$key]->naccounts;

                if($empbcodes[$rows1[$key]->emp_id]==9907)
                {
                    $onlyreg['LCPC Nalgonda'] += $rows1[$key]->naccounts;
                }

                if($empbcodes[$rows1[$key]->emp_id]==9903)
                {
                    $onlyreg['LCPC Vizianagaram'] += $rows1[$key]->naccounts;
                }
            }  

			$onlyreg['Nalgonda'] = $onlyreg['Nalgonda']-$onlyreg['LCPC Nalgonda'];
            $onlyreg['Vizianagaram'] = $onlyreg['Vizianagaram']-$onlyreg['LCPC Vizianagaram'];

            

           
            return view('ckycapp.empsummary')->with(compact('emps','branches','rows1','emparray','empbcodes','datereq','regions','onlyreg'));
        }
        if($request->isMethod('post'))
        {
            $edate = $request->input('edate');
            $query1 = "SELECT emp_id, count(*) as naccounts ,min(updated_at) as logintime, max(updated_at) as logouttime FROM ckyc_temp where UploadStatus_1=1 and date_format(updated_at,'%Y-%m-%d') = '".$edate."' group by emp_id order by naccounts DESC";         
        
            //return $query.Session::get('employee_id');
            $post = [
                'date' => $edate,
            ];
            $ch1 = curl_init('http://3.111.14.201/ckyc/api/summary');
            //$ch1 = curl_init('http://3.111.14.201/ckyc/api/get_date');
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch1, CURLOPT_PROXY, "10.64.1.189"); //your proxy url
            curl_setopt($ch1, CURLOPT_PROXYUSERPWD, "$username:$password");
            curl_setopt($ch1, CURLOPT_PROXYPORT, "3128");
            $response1 = curl_exec($ch1);
            curl_close($ch1);
            $rows1=json_decode($response1);
           

            $emparray = [];
            foreach($rows1 as $key=>$value)
            {
                $emparray[$rows1[$key]->emp_id]['empid'] = $rows1[$key]->emp_id;
                $emparray[$rows1[$key]->emp_id]['naccounts'] = $rows1[$key]->naccounts;
                $emparray[$rows1[$key]->emp_id]['logintime'] = $rows1[$key]->logintime;
                $emparray[$rows1[$key]->emp_id]['logouttime'] = $rows1[$key]->logouttime;
                //$emparray[$rows1[$key]->emp_id]['timediff'] = ceil(date('H', strtotime($rows1[$key]->logouttime) - strtotime($rows1[$key]->logintime)));
                $emparray[$rows1[$key]->emp_id]['timediff'] = round((strtotime($rows1[$key]->logouttime) - strtotime($rows1[$key]->logintime))/3600,1);
                if($emparray[$rows1[$key]->emp_id]['timediff']==0)
                {
                    $emparray[$rows1[$key]->emp_id]['avgaccounts'] = $rows1[$key]->naccounts;
                }
                else{
                    $emparray[$rows1[$key]->emp_id]['avgaccounts'] = ceil($rows1[$key]->naccounts / $emparray[$rows1[$key]->emp_id]['timediff']);
                }
                
                $onlyreg[$regions[$empbcodes[$rows1[$key]->emp_id]]] += $rows1[$key]->naccounts;

                if($empbcodes[$rows1[$key]->emp_id]==9907)
                {
                    $onlyreg['LCPC Nalgonda'] += $rows1[$key]->naccounts;
                }

                if($empbcodes[$rows1[$key]->emp_id]==9903)
                {
                    $onlyreg['LCPC Vizianagaram'] += $rows1[$key]->naccounts;
                }
            }      
            $onlyreg['Nalgonda'] = $onlyreg['Nalgonda']-$onlyreg['LCPC Nalgonda'];
            $onlyreg['Vizianagaram'] = $onlyreg['Vizianagaram']-$onlyreg['LCPC Vizianagaram'];     

            return view('ckycapp.empsummary')->with(compact('emps','branches','rows1','emparray','empbcodes','edate','regions','onlyreg'));
        }
        
    }

    /*public function emp_summary(Request $request)
    {
        return 'donot run this';
    }*/


    public function show_user_data1()
    {
        //$bcode = Config('bcode');
        $emps = EmployeeMaster::pluck('name','emp_id')->toArray();
        $branches = BranchMaster::pluck('BRANCHNAME','bcode')->toArray();
        $emp = Session::get('employee_id');
        $username='6160';
        $password='Apgb$123';
        $query = 'SELECT emp_id, count(*) as naccounts FROM ckyc_temp where UploadStatus_1=1 group by emp_id order by naccounts DESC';
        
        
        //return $query.Session::get('employee_id');
        $post = [
            'query' => $query,
        ];
        $ch = curl_init('http://183.82.116.194/all_query.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_PROXY, "10.64.1.189"); //your proxy url
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_PROXYPORT, "3128");
        $response = curl_exec($ch);
        curl_close($ch);
        $rows=json_decode($response);
        
        return view('ckycapp.empsummary')->with(compact('rows','var_string','emps','branches'));
    }







    public function getuserdata($cifno)
    {
        $username='6160';
        $password='Apgb$123';
        $post = [
            'query' => 'SELECT *
            FROM npa_images where CIF_No='.$cifno,
        ];
        $ch = curl_init('http://183.82.116.194/all_query.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_PROXY, "10.64.1.189"); //your proxy url
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_PROXYPORT, "3128");
        $response = curl_exec($ch);
        curl_close($ch);
        $rows=json_decode($response);
        return $rows;
    }

    public function individual_download($cifnumber)
    {
        $username='6160';
        $password='Apgb$123';
        $post = [
            'query' => 'SELECT * FROM ckyc_temp where CIF_No='.$cifnumber,
        ];
        
        $ch = curl_init('http://183.82.116.194/all_query.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_PROXY, "10.64.1.189"); //your proxy url
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_PROXYPORT, "3128");
        $response = curl_exec($ch);
        curl_close($ch);
        $files_req=json_decode($response);
        //return $files_req[0]->cifnumber;

        $zipFileName = $cifnumber.'.zip';
        $zip = new ZipArchive;        
        if(file_exists(public_path($zipFileName)))
        {
            File::delete(public_path($zipFileName));
        }
        $imageName1 = $cifnumber.'_cust.jpeg';
        $imageName2 = $cifnumber.'_POI.jpeg';
        $imageName3 = $cifnumber.'_POA.jpeg';
        if(!file_exists(public_path($cifnumber)))
        {
            \File::makeDirectory(public_path($cifnumber));
        }
        
        \File::put(public_path($cifnumber). '\\' . $imageName1, base64_decode($files_req[0]->cust_photo));
        \File::put(public_path($cifnumber). '\\' . $imageName2, base64_decode($files_req[0]->cust_id1));
        \File::put(public_path($cifnumber). '\\' . $imageName3, base64_decode($files_req[0]->cust_id2));

        //$this->compress_image($file, $file, 80);
        
        if($zip->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE) 
        { 
            //$this->compress_image(public_path($cifnumber).'\\'.$imageName1, public_path($cifnumber).'\\'.$imageName1, 10);
            //$this->compress_image(public_path($cifnumber).'\\'.$imageName2, public_path($cifnumber).'\\'.$imageName2, 10);
            //$this->compress_image(public_path($cifnumber).'\\'.$imageName3, public_path($cifnumber).'\\'.$imageName3, 10);
            $zip->addFile(public_path($cifnumber).'\\'.$imageName1,$cifnumber.'_photo.jpeg');
            $zip->addFile(public_path($cifnumber).'\\'.$imageName2,$cifnumber.'_POI.jpeg');
            //$zip->addFile(public_path($cifnumber).'\\'.$imageName3,$cifnumber.'_POA.jpeg'); //disabled this for the sake of duplication of ID. Enable this for actual testing.
            $zip->close();
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

    public function download_all($vals)
    {
        //return $vals;
        $cifs = explode(",",$vals);
        //return $cifs;
        $username='6160';
        $password='Apgb$123';
        $post = [
            'query' => 'SELECT * FROM ckyc_temp where CIF_No in ('.$vals.')',
        ];
        
        $ch = curl_init('http://183.82.116.194/all_query.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_PROXY, "10.64.1.189"); //your proxy url
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_PROXYPORT, "3128");
        $response = curl_exec($ch);
        curl_close($ch);
        $files_req=json_decode($response);
        

        foreach($files_req as $key=>$value)
        {
            $imageName1 = $files_req[$key]->CIF_No.'_cust.jpeg';
            $imageName2 = $files_req[$key]->CIF_No.'_POI.jpeg';
            //$imageName3 = $files_req[$key]->CIF_No.'_POA.jpeg';            
            if(file_exists(public_path('download\\').$files_req[$key]->CIF_No))
            {
                //rmdir(public_path('download\\').$files_req[$key]->CIF_No);
                $dirPath = public_path('download\\').$files_req[$key]->CIF_No;
                if (! is_dir($dirPath)) {
                    throw new InvalidArgumentException("$dirPath must be a directory");
                }
                if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                    $dirPath .= '/';
                }
                $files = glob($dirPath . '*', GLOB_MARK);
                foreach ($files as $file) {
                    if (is_dir($file)) {
                        self::deleteDir($file);
                    } else {
                        unlink($file);
                    }
                }
                rmdir($dirPath);
            }           
            
            \File::makeDirectory(public_path('download\\').$files_req[$key]->CIF_No);
            \File::put((public_path('download\\').$files_req[$key]->CIF_No). '\\' . $imageName1, base64_decode($files_req[$key]->cust_photo));
            \File::put((public_path('download\\').$files_req[$key]->CIF_No). '\\' . $imageName2, base64_decode($files_req[$key]->cust_id1));
            //\File::put((public_path('download\\').$files_req[$key]->CIF_No). '\\' . $imageName3, base64_decode($files_req[$key]->cust_id2)); 
            $the_folder = public_path('download\\').$files_req[$key]->CIF_No;
            $zip_file_name = public_path().'\\'.$files_req[$key]->CIF_No.'.zip';
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
                //return 'yes';
                $za->addDir($the_folder, basename($the_folder));
                $za->close();
            }
            else
            {
                echo 'Could not create a zip archive';
            }
            //return response()->download($zip_file_name);           
        }  
        $zipFileName = 'ckyc_download.zip';
        $zip = new ZipArchive;        
        if(file_exists(public_path($zipFileName)))
        {
            File::delete(public_path($zipFileName));
        }        
        if($zip->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE) 
        { 
            foreach($files_req as $key=>$value)
            {
                $zip->addFile(public_path().'\\'.$files_req[$key]->CIF_No.'.zip',$files_req[$key]->CIF_No.'.zip');
            }            
            $zip->close();
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

    



    function compress_image($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        imagejpeg($image, $destination_url, $quality);        
        Log::info("Image uploaded successfully.");
    }

    public function store_image($image1)
    {
        $stringPath = '';
        $stringNames = '';
        $folderPath = public_path('uploads\\');
        $file = $folderPath . 'zef.jpeg';
        $image_base64 = base64_decode($image1);
        file_put_contents($file, $image_base64);                
    }

    public function downloadFile($id)
    {
        try
        {
            $username='6160';
            $password='Apgb$123';
            $post = [
                'query' => 'SELECT *
                FROM npa_images ',
            ];
            $ch = curl_init('http://183.82.116.194/all_query.php');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_PROXY, "10.64.1.189"); //your proxy url
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$username:$password");
            curl_setopt($ch, CURLOPT_PROXYPORT, "3128");
            $response = curl_exec($ch);
            curl_close($ch);
            $rows=json_decode($response);
            $this->store_image($rows[0]->image);
                



            $userpresent = ckycModel::where('id',$id)->first();
            $zipFileName = $userpresent->cifnumber.'.zip';
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
