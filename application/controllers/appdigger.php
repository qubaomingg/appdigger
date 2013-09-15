<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appdigger extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('app_model');
		$this->load->helper('url');
	} 
	
	
	public function index()
	{
         
        
		$data = array();
		$version = 1;
		$apps = $this->app_model->get_from_version($version);
		$nums = $this->app_model->get_nums();
		$data['nums'] = $nums;
		
	    $apps = $this->generateUrl($apps);
       
        
        $data['apps'] = $apps;
       
		$this->load->view('appdigger',$data);
	}
    
    public function get_link_byname($name)
    {
    	$link = $this->app_model->get_link($name);
        return  $link;
        
    }
    public function test() 
    {
        echo "test";
    }
    public function erwei($appName = 0, $from_Apple = 0) 
    {
        $final_url = '';

        $from_Apple = (int)$from_Apple;
        $phone_iphone = preg_match('/Apple/i',$_SERVER['HTTP_USER_AGENT']); // 1 是 android
        $appName = urldecode($appName); // 对特殊字符转码
        $myLink = $this->get_link_byname($appName);
        $link = $myLink[0]['appLink'];
        
        
        if( $from_Apple === $phone_iphone )
        {
            // 手机是和链接对应。
            $final_url = $link;
            
            //$final_url = 'http://www.baidu.com';
            echo "<script language='javascript'>"; 
            echo "location.href='".$final_url."'"; 
            echo "</script>"; 	
        }
        if( ($from_Apple === 0) && ($phone_iphone === 1))
        {
            // 手机apple 链接 google
         	
            $final_url_list_obj = file_get_contents("https://itunes.apple.com/search?country=cn&entity=software&term='".$appName."'");
            //$final_url_list_obj = file_get_contents("http://www.baidu.com");
            $final_url_list_obj = json_decode($final_url_list_obj); // string to json.
             
            $url_list = (array)$final_url_list_obj;

            $urls = $url_list['results'];
            //$urls = $url_list['results'] = (array)$url_list['results'];

            
            foreach ($urls as $key => $value) {
                $value = (array)$value;
                $urls[$key] = $value;
            }
            
            $data['url_list'] = $urls;
            $this->load->view('apple_list',$data);

            // app
        }
       	if(($from_Apple === 1)&&($phone_iphone === 0))
        {
            // 手机android 链接 app store
            echo "this app is ios application, you are going to google play.....";
            sleep(2);
            $final_url = 'https://play.google.com/store/search?q='.$appName; 
            echo "<script language='javascript'>"; 
            echo "location.href='".$final_url."'"; 
            echo "</script>"; 
        }
    }
    
	public function erweima($chl,$x ='150',$level='L',$margin='0'){
	    return 'http://chart.apis.google.com/chart?chs='.$x.'x'.$x.'&cht=qr&chld='.$level.'|'.$margin.'&chl='.urlencode($chl);
	}
	public function generateUrl($apps)
	{
        
		if( $apps == FALSE) return FALSE;
		foreach ($apps as $key => $value) 
		{
			foreach ($value as $key_sub => $value_sub) 
			{
                //$apps[$key]['erweilink'] = $apps[$key]['appName'];
                if($key_sub === 'appLink') 
                {
                    $matches = array();
                    $isApple = preg_match('/itunes/i', $apps[$key]['appLink'], $matches);
                    $url = base_url().'index.php/appdigger/erwei/'.$apps[$key]['appName'].'/'.$isApple;
                    
                	$apps[$key]['erweilink'] = $this->erweima($url);
                }
			}																																
		}
        
		return $apps;
	}
	
	public function get_version_content($index) 
	{	
		
		$apps = $this->app_model->get_from_version($index);
		$nums = $this->app_model->get_nums();
		$data['nums'] = $nums;
         $apps = $this->generateUrl($apps);
         $data['apps'] = $apps;
		
		$this->load->view('appdigger',$data);
	}
    public function get_last_version() 
    {
     	$lastestVersion = $this->app_model->getLasteVersion();
        
        return $lastestVersion[0];
    }
	public function like_obj()
	{ 
		$data = array();
		$early = "还不是提交时间哦，亲～　";
		$needinfo = "信息不完整或者时间有误，如需帮助请联系alanqu.";

		if(isset($_POST['info'])) {
		   $info = stripslashes(trim($_POST['info']));
            //$test = '{"a":1,"b":2}';
            $data = json_decode($info, true);
           
            //$data = $this->generateUrl($data);
            $last_version = $this->get_last_version();
            
            if($last_version['can'] == '0') 
            {
            	$data['back'] = $early;
            	$this->load->view('return', $data);
            } else {
            	$this->app_model->save_des($data, $last_version['version']);
            	$data['back'] = "Hi,".$data['userName'].', thanks for your time';
            	$this->load->view('return', $data);
            }
                
		} else {
			$data['back'] = $needinfo;
            	$this->load->view('return', $data);
			
		}
		
	}

	
}


