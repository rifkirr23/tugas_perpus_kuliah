<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classimport extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){

		parent::__construct();
		cek_session(); //cek session User Login
// 		$idcust=$this->session->userdata('id_cust');
// 	    $cek_aman=$this->db->select('level')->from('pengguna_customer')->where('id_cust',$idcust)->get()->row();
// 		if($cek_aman->level == '2'){
// 		}else{
// 		    redirect('https://wilopocargo.com/jagoan-impor#daft');
// 		}
		// $this->load->model('Mcustomer'); //Load Model Customer
		// $this->load->model('Mtransaksi'); //Load Model Customer
		// $this->load->model('Minvoice'); //Load Model Customer
		// $this->load->model('Mpembayaran'); //Load Model Customer
		// $this->load->model('Mjenis_barang_customer'); //Load Model Customer
	}

	//Function Halaman Awal Menu Customer
	 function generate(){
		$API_key    = 'AIzaSyCW-uagYO0Xsn017jNsJpFgUc00FF9r3QQ';

		$channelID  = 'PL9Jfjjvc9Pq9_GddkBmPNw7j8BpABPO_w';

		$maxResults = 50;
		$part='snippet';
		$idyoutube='youtu.be/91EZsZmj3gM';

		// $parse['lv'] = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/search?order=date&channelId=".$channelID."&maxResults=".$maxResults."&key=".$API_key."&part=snippet&q=".$idyoutube));
		$videoList = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?playlistId=".$channelID."&maxResults=".$maxResults."&key=".$API_key."&part=".$part));
		// $videoListfgh = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=91EZsZmj3gM&part=contentDetails&key=".$API_key));
		// https://www.googleapis.com/youtube/v3/videos?id=9bZkp7q19f0&part=contentDetails&key={YOUR_API_KEY}
// 		foreach($videoList->items AS $item){
//   echo $item->player;
// }
		// var_dump($videoList->items);
		foreach($videoList->items as $item){
			// if($item->snippet->resourceId->videoId == 'DN0uO5diuoA'){
			   $idtonton=$this->db->select('y_video.videoId')->from('y_video')->where('videoId', $item->snippet->resourceId->videoId)->get()->row();
			   if(empty($idtonton->videoId)){
    				$vid['videoId'] = $item->snippet->resourceId->videoId;
    				$vid['thumbnails'] = $item->snippet->thumbnails->medium->url;;
    				$vid['title'] = $item->snippet->title;
    				$vid['description'] = $item->snippet->description;

    				$this->db->insert('y_video', $vid);
    				// var_dump($item->snippet->resourceId->videoId);
			    }
// 			}
		}
	 }
	 function index(){
		$API_key    = 'AIzaSyCW-uagYO0Xsn017jNsJpFgUc00FF9r3QQ';

		$channelID  = 'UCYMtwAeL1xLETRezmyAtbWg';

		$maxResults = 10;
		$part='snippet';
		$idyoutube='youtu.be/91EZsZmj3gM';

		// $parse['lv'] = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/search?order=date&channelId=".$channelID."&maxResults=".$maxResults."&key=".$API_key."&part=snippet&q=".$idyoutube));
		$idcust=$this->session->userdata('id_cust');
		$parse['kategori']=$this->db->select('kategori_video.*')->from('kategori_video')
                        ->get()->result();
// 		var_dump($kategori);

	    $parse['lv']=$this->db->select('y_video.*')->from('y_video')->order_by('title', 'ASC')->get()->result();

		$idtonton=$this->db->select('status_tonton.videoid, y_video.id_kategori_video, y_video.no_urut')->from('status_tonton')->join('y_video', 'status_tonton.videoid=y_video.videoId', 'left')->where('id_cust', $idcust)->order_by('status_tonton.id', 'desc')->get()->row();
		if(isset($idtonton->videoid)){
		    $kateg=$idtonton->id_kategori_video;
		    $urutnya=$idtonton->no_urut;
		}else{
		   $idtonton=array();
		   $kateg=0;
		    $urutnya=0;
		}


		$cekada=$this->db->select('y_video.videoId')->from('y_video')->join('status_tonton', 'y_video.videoId=status_tonton.videoid', 'left')->where('y_video.id_kategori_video', $kateg)->where('y_video.no_urut >', $urutnya)->order_by('y_video.title', 'ASC')->get()->row();
		if(isset($cekada->videoId)){
		    $dcekada=$cekada->videoId;
		}else{
		    $dcekada='';
		    $cekada=array();
		}
		$parse['lj']=array();
		if($dcekada !=''){
		    $parse['lj']=$this->db->select('y_video.id, kategori_video.judul')->from('y_video')->join('status_tonton', 'y_video.videoId=status_tonton.videoid', 'left')->join('kategori_video', 'y_video.id_kategori_video=kategori_video.id', 'left')->where('y_video.id_kategori_video', $kateg)->where('y_video.no_urut >', $urutnya)->order_by('y_video.title', 'ASC')->get()->row();
		}else if(!isset($idtonton->videoid)){
		    $parse['lj']=$this->db->select('y_video.id, kategori_video.judul')->from('y_video')->join('status_tonton', 'y_video.videoId=status_tonton.videoid', 'left')->join('kategori_video', 'y_video.id_kategori_video=kategori_video.id', 'left')->order_by('kategori_video.id', 'ASC')->order_by('y_video.no_urut', 'ASC')->get()->row();
		}
		else{
		    $parse['lj']=$this->db->select('y_video.id, kategori_video.judul')->from('y_video')->join('status_tonton', 'y_video.videoId=status_tonton.videoid', 'left')->join('kategori_video', 'y_video.id_kategori_video=kategori_video.id', 'left')->where('y_video.id_kategori_video >', $kateg)->order_by('y_video.title', 'ASC')->get()->row();
		}
		// var_dump($hbd);
		// $videoListfgh = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=91EZsZmj3gM&part=contentDetails&key=".$API_key));
		// https://www.googleapis.com/youtube/v3/videos?id=9bZkp7q19f0&part=contentDetails&key={YOUR_API_KEY}
		// var_dump($videoList);
		// foreach($videoList->items as $item){

		// 	if(isset($item->id->videoId)){

		// 	echo '<div class="youtube-video">

		// 			<iframe width="280" height="150" src="https://www.youtube.com/embed/'.$item->id->videoId.'" frameborder="0" allowfullscreen></iframe>

		// 			<h2>'.$item->snippet->title.'</h2>

		// 		</div>';

		// 	}

		// }
		$parse['jumditonton']=$this->db->select('count(id) as jumlahnya')->from('status_tonton')
		->where('id_cust',$idcust)
		->get()->row();
		$this->template->load('template_dashboard','dashboard/classimport/classimport',$parse);
	}

	//Function Get play
	function play() {
		$id= $this->uri->segment(3);
		$idcust=$this->session->userdata('id_cust');
		$datesekarang=date("Y-m-d H:i:s");

        $selectvid=$this->db->select('videoId, id_kategori_video')->from('y_video')
                        ->where('id',$id)
                        ->get()->row();
		$statustonton=$this->db->select('id')->from('status_tonton')
                        ->where('videoid',$selectvid->videoId)
                        ->where('id_cust',$idcust)
                        ->get()->row();
        if(empty(@$statustonton->id)){
			$vidstat['id_cust'] = $idcust;
			$vidstat['videoid'] = $selectvid->videoId;
			$vidstat['tgl_tonton'] = $datesekarang;

			$this->db->insert('status_tonton', $vidstat);
		}

		$API_key    = 'AIzaSyCW-uagYO0Xsn017jNsJpFgUc00FF9r3QQ';

		$channelID  = 'UCYMtwAeL1xLETRezmyAtbWg';
		$kategorisel=@$selectvid->id_kategori_video+1;
		$parse['katsel']=$this->db->select('id')->from('y_video')->where('id_kategori_video',@$kategorisel)->order_by('title', 'ASC')->get()->row();

		$maxResults = 10;
		$idyoutube='youtu.be/'.$id;
		$parse['lv']=$this->db->select('y_video.*')->from('y_video')->where('id_kategori_video',@$selectvid->id_kategori_video)->order_by('title', 'ASC')->get()->result();
		$parse['detail']=$this->db->select('y_video.*')->where('id', $id)->from('y_video')->get()->row();
		$this->load->view('dashboard/classimport/play',$parse);
	}


}
