<?php
namespace Modules\Superadmin\Http\Controllers;

/**
 * Description of TrackTransectionController
 *
 * @author Shaju
 */
use Illuminate\Http\Request;

class TrackTransectionController extends BaseController{
    
    /*
     * -------------------------------------------------------------------------
     * Trace Transection Part
     * -------------------------------------------------------------------------
    */
    
    // for Demo
    //public $store_id ="testbox";
    //public $store_passwd ="qwerty";
    //public $url="https://sandbox.sslcommerz.com/validator/api/merchantTransIDvalidationAPI.php";
    
    // Live
    
    public $store_id ="perkyrabbit002live";
    public $store_passwd ="5C35A870A54B291007";   
    public $url ="https://securepay.sslcommerz.com/validator/api/merchantTransIDvalidationAPI.php";
   
   
   
   

   public function TrackTransectionPageShow() {
       return view('superadmin::superadmin.trackTransection');
   } 
   
   public function ShowTrackData(Request $request) {
       $tran_id = $request->tran_id;
       $field = '?tran_id='.$tran_id.'&store_id='.$this->store_id.'&store_passwd='.$this->store_passwd;
       $this->url = $this->url.$field;
       	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $this->url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	 
	$output = curl_exec($ch);	 
	curl_close($ch);
        $data = json_decode($output , true);
        return view('superadmin::superadmin.trackTransection',['data'=>$data]);
   }
   
   
}
