
<?php
	
//	CREATE BY NONTACHAI KORNINAI
//	01 OCTOBER 2016
//
//	UPDATE BY NONTACHAI KORNINAI
//	25 MARCH 2018
	
require_once __DIR__ . '/setting.php';
class Linebot {
	private $channelAccessToken;
	private $channelSecret;
	private $webhookResponse;
	private $webhookEventObject;
	private $apiReply;
	private $apiPush;
	
	public function __construct(){
		$this->channelAccessToken = Setting::getChannelAccessToken();
		$this->channelSecret = Setting::getChannelSecret();
		$this->apiReply = Setting::getApiReply();
		$this->apiPush = Setting::getApiPush();
		$this->webhookResponse = file_get_contents('php://input');
		$this->webhookEventObject = json_decode($this->webhookResponse);
	}
	
	private function httpPost($api,$body){
		$ch = curl_init($api); 
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body)); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
		'Content-Type: application/json; charser=UTF-8', 
		'Authorization: Bearer '.$this->channelAccessToken)); 
		$result = curl_exec($ch); 
		curl_close($ch); 
		return $result;
	}
	
	public function reply($text){
		$api = $this->apiReply;
		$webhook = $this->webhookEventObject;
		$replyToken = $webhook->{"events"}[0]->{"replyToken"}; 
		$body["replyToken"] = $replyToken;
		$body["messages"][0] = array(
			"type" => "text",
			"text"=>$text
		);
		
		$result = $this->httpPost($api,$body);
		return $result;
	}
	
	public function push($body){
		$api = $this->apiPush;
		$result = $this->httpPost($api, $body);
		return $result;
    	}

    public function pushText($to, $text){
		$body = array(
		    'to' => $to,
		    'messages' => [
			array(
			    'type' => 'text',
			    'text' => $text
			)
		    ]
		);
		$this->push($body);
	 }

   	public function pushImage($to, $imageUrl, $previewImageUrl = false){
        	$body = array(
		    'to' => $to,
		    'messages' => [
			array(
			    'type' => 'image',
			    'originalContentUrl' => $imageUrl,
			    'previewImageUrl' => $previewImageUrl ? $previewImageUrl : $imageUrl
			)
		    ]
		);
		$this->push($body);
    	}

    public function pushVideo($to, $videoUrl, $previewImageUrl){
        	$body = array(
          	  'to' => $to,
          	  'messages' => [
          	      array(
			    'type' => 'video',
			    'originalContentUrl' => $videoUrl,
			    'previewImageUrl' => $previewImageUrl
			)
		    ]
		);
        	$this->push($body);
    	}

    public function pushAudio($to, $audioUrl, $duration){
		$body = array(
		    'to' => $to,
		    'messages' => [
			array(
			    'type' => 'audio',
			    'originalContentUrl' => $audioUrl,
			    'duration' => $duration
			)
		    ]
		);
		$this->push($body);
	}

    public function pushLocation($to, $title, $address, $latitude, $longitude){
		$body = array(
		    'to' => $to,
		    'messages' => [
			array(
			    'type' => 'location',
			    'title' => $title,
			    'address' => $address,
			    'latitude' => $latitude,
			    'longitude' => $longitude
			)
		    ]
		);
		$this->push($body);
	}
	
	public function getMessageText(){
		$webhook = $this->webhookEventObject;
		$messageText = $webhook->{"events"}[0]->{"message"}->{"text"}; 
		return $messageText;
	}
	
	public function postbackEvent(){
		$webhook = $this->webhookEventObject;
		$postback = $webhook->{"events"}[0]->{"postback"}->{"data"}; 
		return $postback;
	}
	
	public function getUserId(){
		$webhook = $this->webhookEventObject;
		$userId = $webhook->{"events"}[0]->{"source"}->{"userId"}; 
		return $userId;
	}

	//tambahan fungsi reply Image
	public function replyImage($imageUrl, $previewImageUrl = false){
		$api = $this->apiReply;
		$webhook = $this->webhookEventObject;
		$replyToken = $webhook->{"events"}[0]->{"replyToken"}; 
		$body["replyToken"] = $replyToken;
		$body["messages"][0] = array(
			    'type' => 'image',
			    'originalContentUrl' => $imageUrl,
			    'previewImageUrl' => $previewImageUrl ? $previewImageUrl : $imageUrl
			);		
		$result = $this->httpPost($api,$body);
		return $result;
	}

	//tambahan fungsi reply Video
	public function replyVideo($videoUrl, $previewImageUrl){
		$api = $this->apiReply;
		$webhook = $this->webhookEventObject;
		$replyToken = $webhook->{"events"}[0]->{"replyToken"}; 
		$body["replyToken"] = $replyToken;
		$body["messages"][0] =  array(
			    'type' => 'video',
			    'originalContentUrl' => $videoUrl,
			    'previewImageUrl' => $previewImageUrl
			);		
		$result = $this->httpPost($api,$body);
		return $result;
	}
	
	//tambahan fungsi reply Audio
	public function replyAudio($audioUrl, $duration){
		$api = $this->apiReply;
		$webhook = $this->webhookEventObject;
		$replyToken = $webhook->{"events"}[0]->{"replyToken"}; 
		$body["replyToken"] = $replyToken;
		$body["messages"][0] =  array(
			    'type' => 'audio',
			    'originalContentUrl' => $audioUrl,
			    'duration' => $duration
			);		
		$result = $this->httpPost($api,$body);
		return $result;
	}

	//tambahan fungsi reply Location
	public function replyLocation($title, $address, $latitude, $longitude){
		$api = $this->apiReply;
		$webhook = $this->webhookEventObject;
		$replyToken = $webhook->{"events"}[0]->{"replyToken"}; 
		$body["replyToken"] = $replyToken;
		$body["messages"][0] =  array(
			    'type' => 'location',
			    'title' => $title,
			    'address' => $address,
			    'latitude' => $latitude,
			    'longitude' => $longitude
			);		
		$result = $this->httpPost($api,$body);
		return $result;
	}

	//tambahan fungsi reply Video
	public function replySticker($packageID, $stickerID){
		$api = $this->apiReply;
		$webhook = $this->webhookEventObject;
		$replyToken = $webhook->{"events"}[0]->{"replyToken"}; 
		$body["replyToken"] = $replyToken;
		$body["messages"][0] =  array(
			    'type' => 'sticker',
			    'packageId' => $packageID,
			    'stickerId' => $stickerID
			);		
		$result = $this->httpPost($api,$body);
		return $result;
	}


	//tambahan fungsi template button
	public function replyButton($text,$aksi1,$aksi2,$thumbnailImageUrl=NULL){
		$api = $this->apiReply;
		$webhook = $this->webhookEventObject;
		$replyToken = $webhook->{"events"}[0]->{"replyToken"}; 
		$body["replyToken"] = $replyToken;
		$body["messages"][0] =  array(
			    'type' => 'template',
			    'altText' => 'Button template',
			    'template' => array(
			    	'type' => 'buttons',
			    	'thumbnailImageUrl' => $thumbnailImageUrl,
			    	'text' => $text,
			    	'actions' => [ 
			    		array(
			    			'type' => 'message',
			    			'label' => ucfirst($aksi1),
			    			'text' => $aksi1
			    		), 
			    		array(
			    			'type' => 'message',
			    			'label' => ucfirst($aksi2),
			    			'text' => $aksi2
			    		)
			    	]
			    )			    
			);		
		$result = $this->httpPost($api,$body);
		return $result;
	}

	//tambahan fungsi template button
	public function replyConfirm($text,$aksi1,$aksi2){
		$api = $this->apiReply;
		$webhook = $this->webhookEventObject;
		$replyToken = $webhook->{"events"}[0]->{"replyToken"}; 
		$body["replyToken"] = $replyToken;
		$body["messages"][0] =  array(
			    'type' => 'template',
			    'altText' => 'Confirm template',
			    'template' => array(
			    	'type' => 'confirm',
			    	'text' => $text,
			    	'actions' => [ 
			    		array(
			    			'type' => 'message',
			    			'label' => ucfirst($aksi1),
			    			'text' => $aksi1
			    		), 
			    		array(
			    			'type' => 'message',
			    			'label' => ucfirst($aksi2),
			    			'text' => $aksi2
			    		)
			    	]
			    )			    
			);		
		$result = $this->httpPost($api,$body);
		return $result;
	}

	// tambahan fungsi template Carousel
	public function replyCarousel($data_kolom1,$data_kolom2,$data_kolom3){
		$api = $this->apiReply;
		$webhook = $this->webhookEventObject;
		$replyToken = $webhook->{"events"}[0]->{"replyToken"}; 
		$body["replyToken"] = $replyToken;
		$body["messages"][0] =  array(
			    'type' => 'template',
			    'altText' => 'Carousel template',
			    'template' => array(
			    	'type' => 'carousel',
			    	'columns' => [
			    		$data_kolom1,
			    		$data_kolom2,
			    		$data_kolom3
			    	]	
			    )		    
			);		
		$result = $this->httpPost($api,$body);
		return $result;
	}

}
