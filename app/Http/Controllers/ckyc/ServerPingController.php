<?php

namespace App\Http\Controllers\ckyc;

use App\Http\Controllers\ckyc\Controller;
use Illuminate\Http\Request;
use App\Models\ServerPingModel;
use Log;

class ServerPingController extends Controller
{
    public function testping(Request $request)
    {
        /*$ip_addr = '10.64.141.58';
        if ((new CheckDevice())->ping($ip_addr))
        {
            echo "The device exists";
        }
        else
        {
            echo "The device is not connected";
        }
        return;*/
        
        $sdetails =  ServerPingModel::all();
        $pingarray = [];
        $nopingarray = [];
        $start_time = time();
        foreach($sdetails as $key=>$value)
        {
            if ((new CheckDevice())->ping($sdetails[$key]->ipaddress))
            {
                $sdetails[$key]->type="Pinging";
                //$pingarray[$sdetails[$key]->ipaddress] = $sdetails[$key]->bcode;
                //echo "pining".$sdetails[$key]->id.'<br/>';
            }
            else
            {
                $sdetails[$key]->type="Not Pinging";
                //$nopingarray[$sdetails[$key]->ipaddress] = $sdetails[$key]->bcode;
                //echo "Not pining".$sdetails[$key]->id.'<br/>';
            }
        } 
        $end_time = time();
        //return $end_time - $start_time;
        //return;       
        //return $sdetails;
        //return "Completed";
        return view('ckyc.serverping')->with(compact('sdetails'));
    }

    public function test_allpings()
    {
        $bip = "10.65.44.33";
        $dtype = [];
        $start_time = time();
        for($i=0;$i<=255;$i++)
        {
            $sip = explode('.',$bip);
            $sip = $sip[0].'.'.$sip[1].'.'.$sip[2].'.'.$i;
            //echo $sip.'<br/>';
            if ((new CheckDevice())->ping($sip))
            {
                $dtype[$sip]="Pinging";
                //$pingarray[$sdetails[$key]->ipaddress] = $sdetails[$key]->bcode;
                //echo "pining".$sdetails[$key]->id.'<br/>';
            }
            else
            {
                $dtype[$sip]="Not Pinging";
                //$nopingarray[$sdetails[$key]->ipaddress] = $sdetails[$key]->bcode;
                //echo "Not pining".$sdetails[$key]->id.'<br/>';
            }
        }
        $end_time = time();
        return $end_time-$start_time;
    }

    public function testpingview()
    {
        return view('ckyc.serverping');
    }

    public function searchIpPing(Request $request,$sip)
    {
        $sdetails =  ServerPingModel::where('ipaddress',$sip)->first();
        if ((new CheckDevice())->ping($sip))
        {
            if(!empty($sdetails))
            {
                $details['bcode'] = $sdetails->bcode;
                $details['ipaddress'] = $sdetails->ipaddress;
                $details['status'] = 'Pinging';
                return response()->json($details);
            }
            else{
                $details['bcode'] = 'MissingFunc';
                $details['ipaddress'] = $sip;
                $details['status'] = 'Pinging';
                return response()->json($details);
            }
            
        }
        else
        {
            if(!empty($sdetails))
            {
                $details['bcode'] = $sdetails->bcode;
                $details['ipaddress'] = $sdetails->ipaddress;
                 $details['status'] = 'Not Pinging';
                return response()->json($details);
            }
            else{
                $details['bcode'] = 'MissingFunc';
                $details['ipaddress'] = $sip;
                $details['status'] = 'Not Pinging';
                return response()->json($details);
            }
            
        }
        
    }
}

class CheckDevice {

    public function myOS(){
        if (strtoupper(substr(PHP_OS, 0, 3)) === (chr(87).chr(73).chr(78)))
            return true;
        return false;
    }

    /*public function ping($ip_addr){
        if ($this->myOS()){
            if (!exec("ping -n 1 -w 1 ".$ip_addr." 2>NUL > NUL && (echo 0) || (echo 1)"))
                return true;
        } else {
            if (!exec("ping -q -c1 ".$ip_addr." >/dev/null 2>&1 ; echo $?"))
                return true;
        }

        return false;
    }*/
    public function ping($ip_addr){
        if ($this->myOS()){
            if (!exec("ping -n 1 -w 1 ".$ip_addr." 2>NUL > NUL && (echo 0) || (echo 1)"))
                return true;
        } else {
            if (!exec("ping -q -c1 ".$ip_addr." >/dev/null 2>&1 ; echo $?"))
                return true;
        }

        return false;
    }
}
