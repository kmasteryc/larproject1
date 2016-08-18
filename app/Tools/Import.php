<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 5/29/16
 * Time: 12:54 AM
 */

namespace Tools;

use GuzzleHttp;

class Import
{

	protected $_url = '';
	protected $_content = '';
	protected $_jsonLink = '';
	protected $_jsonData = '';
	protected $_results = '';
	protected $_errors = '';
	protected $_playlist_img = '';

	function getResults()
	{
		return $this->_results;
	}

	function getErrors()
	{
		return $this->_errors;
	}

	function __construct($url)
	{
		$this->_url = $url;

		$this->_content = $this->getPageContent($url);
		$this->_jsonLink = $this->getJsonLink($this->_content);
		$this->_jsonData = $this->getJsonData($this->_jsonLink);

		$this->setPlaylistImg();

		$items = $this->getMP3($this->_jsonData);

		$this->_results = isset($items) ? $items : null;
	}

	function getJsonLink($content)
	{
		$regex = "/xmlURL=(http:\\/\\/mp3\\.zing\\.vn\\/xml\\/[song|video|album]+-xml\\/[a-zA-Z]+)&amp;/";
		preg_match($regex, $content, $matches);

		if (count($matches) === 2) {
			// Replace xml to html5xml due of new Zing version
			$matches[1] = str_replace("/xml/", "/html5xml/", $matches[1]);

			return $matches[1];
		} else {
			$this->_errors = 'Khong the lay link JSON';
			return;
		}
	}

	function getJsonData($url)
	{
		return $this->getPageContent($url);
	}

	function getPageContent($url)
	{
		global $client;
		if (!$client) {
			$client = new GuzzleHttp\Client();
		}
		try {
			$res = $client->get($url);
		} catch (\Exception $e) {
			$this->_errors = $e->getMessage();

			return;
		}
		if ($res->getStatusCode() === 200) {
			return $res->getBody()->getContents();
		} else {
			return null;
		}
	}

	function setPlaylistImg()
	{
		preg_match('/<img width="120" class="pthumb" src="(.*)" alt/', $this->_content, $match);
		$this->_playlist_img = $match[1];
	}
	function getPlaylistImg(){
		return $this->_playlist_img;
	}

	function getMP3($json_date)
	{
		$all = json_decode($json_date);
		$res = [];
		foreach ($all->data as $song){
			$song_source = $song->source_list[0] == '' ? $song->source_list[1] : $song->source_list[0];
			$res[] = [
				'title' => $song->name,
				'source' => $song->source_base.$song_source,
				'performer' => $song->artist,
				'lyric' => $song->lyric,
				'playlist_img' => $this->getPlaylistImg()
			];
		}

		return $res;
	}
}