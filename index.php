<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
//ambil chat user
$text = $bot->getMessageText();

//mengubah chat userke huruf kecil
$chat=strtolower($text);

if($chat=='hai' || $chat=='halo' || $chat=='hello' || $chat=='hi') {
	$balas='hai';
	$bot->reply($balas);
} else if($chat=='siapa nama mu ?') {
	$balas='nama ku CybertechBot chat bot Line dengan PHP';
	$bot->reply($balas);
} else if($chat=='salam') {
	$balas='Salam kenal yah..';
	$bot->reply($balas);
} else if ($chat=='gambar'){
	$url='https://source.unsplash.com/random/240x240';
	$prev_url='https://source.unsplash.com/random/240x240';
	$bot->replyImage($url,$prev_url);
} else if ($chat=='video'){
	$url='https://www.youtube.com/watch?v=xVLieB_AdIc';
	$prev_url='https://source.unsplash.com/random/240x240';
	$bot->replyVideo($url,$prev_url);
} else if ($chat=='smile'){
	$packID='1';
	$stikerID='4';
	$bot->replySticker($packID,$stikerID);
} else if ($chat=='button'){
	$pesan='Coba Template Button';
	$button1='oke';
	$button2='batal';
	$prev_url='https://source.unsplash.com/random/240x240';
	$bot->replyButton($pesan,$button1,$button2,$prev_url);
} else if ($chat=='confirm'){
	$pesan='Apakah anda Yakin?';
	$button1='ya';
	$button2='tidak';
	$bot->replyConfirm($pesan,$button1,$button2);
} else if ($chat=='carousel'){
	$data1=array(
		'thumbnailImageUrl' =>'https://source.unsplash.com/random/240x240',
		'text' => 'Carousel 1',
		'actions' => [
				array(
					'type' => 'message',
				    'label' => 'Carousel 1',
				    'text' => 'Carousel 1'
				)
			]
		);
	$data2=array(
		'thumbnailImageUrl' =>'https://source.unsplash.com/random/240x240',
		'text' => 'Carousel 2',
		'actions' => [
				array(
					'type' => 'message',
				    'label' => 'Carousel 2',
				    'text' => 'Carousel 2'
				)
			]
		);
	$data3=array(
		'thumbnailImageUrl' =>'https://source.unsplash.com/random/240x240',
		'text' => 'Carousel 3',
		'actions' => [
				array(
					'type' => 'message',
				    'label' => 'Carousel 3',
				    'text' => 'Carousel 3'
				)
			]
		);
	$bot->replyCarousel($data1,$data2,$data3);
} else {
	$balas="Maaf saya kurang paham";
	$bot->reply($balas);
}

