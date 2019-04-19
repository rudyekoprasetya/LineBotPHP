<?php

class Setting {
	public function getChannelAccessToken(){
		$channelAccessToken = "sQsc5Wxn2hFo0oMPlw17L6DaAI17XzSYPjM+gzxV4pLORYQF763b7iRgyF71kLhV8w4IJyioA9QNe/fyItSTAazDPqlIgxfwvLIFdOtbzzkpjMxCJpjrhTEvH14bUkJyxY+F6XAKQcyy1/4NQT65MgdB04t89/1O/w1cDnyilFU=";
		return $channelAccessToken;
	}
	public function getChannelSecret(){
		$channelSecret = "3705467fcf6c385a7e7e24cf8ba6aea7";
		return $channelSecret;
	}
	public function getApiReply(){
		$api = "https://api.line.me/v2/bot/message/reply";
		return $api;
	}
	public function getApiPush(){
		$api = "https://api.line.me/v2/bot/message/push";
		return $api;
	}
}