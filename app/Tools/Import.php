<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 5/29/16
 * Time: 12:54 AM
 */

namespace Tools;
use GuzzleHttp;
use Symfony\Component\DomCrawler\Crawler;

class Import
{
	protected $_url ='';
	protected $_type ='';
	protected $_content ='';
	protected $_xmlLink ='';
	protected $_xmlData ='';
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

		$this->_type = $this->getLinkType($url);
		$this->_content = $this->getPageContent($url);
		$this->_xmlLink = $this->getXMLLink($this->_content);
		$this->_xmlData = $this->getXMLData($this->_xmlLink);

		switch($this->_type){
			case 'bai-hat':
				$items = $this->getAudioItems($this->_xmlData);
				break;
			case 'album':
				$this->setPlaylistImg();
				$items = $this->getAudioItems($this->_xmlData);
				break;
			case 'video-clip':
				$items = $this->getVideoItems($this->_xmlData);
				break;
		}
		$this->_results = isset($items)?$items:null;
	}

	function getLinkType($url)
	{
		$regex = "/http:\\/\\/mp3\\.zing\\.vn\\/(bai-hat|album|video-clip|playlist)\\/(?:.*)/";
		preg_match($regex, $url, $matches);
		if (count($matches) === 2) {
			return $matches[1];
		} else {
			return FALSE;
		}
	}

	function getXMLLink($content)
	{
		$regex = "/xmlURL=(http:\\/\\/mp3\\.zing\\.vn\\/xml\\/[song|video|album]+-xml\\/[a-zA-Z]+)&amp;/";
		preg_match($regex, $content, $matches);
		if (count($matches) === 2) {
			return $matches[1];
		} else {
			$this->_errors = 'Khong the lay link XML';
			return;
		}
	}

	function getXMLData($url)
	{
		$content = $this->getPageContent($url);
		if (!$content) {
			$this->_errors = 'Khong the lay du lieu XML';
			return;
		}
		$content = '<?xml version="1.0" encoding="UTF-8"?>' . $content;
		return new Crawler($content);
	}

	function getPageContent($url)
	{
		global $client;
		if (!$client) {
			$client = new GuzzleHttp\Client();
		}
		try{
			$res = $client->get($url);
		}catch (\Exception $e)
		{
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
		preg_match('/<img width="120" class="pthumb" src="(.*)" alt/',$this->_content,$match);
		$this->_playlist_img = $match[1];
	}

	function getAudioItems(Crawler $crawler)
	{
		$items = $crawler->filterXPath('//data/item')->each(function (Crawler $node, $i) {
			return array(
				'title' => $node->filterXPath('//title')->text(),
				'performer' => $node->filterXPath('//performer')->text(),
				'link' => $node->filterXPath('//link')->text(),
				'source' => $node->filterXPath('//source')->text(),
				'lyric' => $node->filterXPath('//lyric')->text(),
				'backimage' => $node->filterXPath('//backimage')->text(),
				'playlist_img' => $this->_playlist_img
			);
		});
		return $items;
	}

	function getVideoItems(Crawler $crawler)
	{
		$items = $crawler->filterXPath('//data/item')->each(function (Crawler $node, $i) {
			$item = array(
				'title' => $node->filterXPath('//title')->text(),
				'performer' => $node->filterXPath('//performer')->text(),
				'link' => $node->filterXPath('//link')->text(),
				'duration' => $node->filterXPath('//duration')->text(),
				'cover' => $node->filterXPath('//cover')->text(),
				'mp3link' => $node->filterXPath('//mp3link')->text(),
				'thumbnail' => $node->filterXPath('//thumbnail')->text(),
			);
			if ($f240 = $node->filterXPath('//f240')) {
				$item['f240'] = $f240->text();
			}
			if ($f360 = $node->filterXPath('//f360')) {
				$item['f360'] = $f360->text();
			}
			if ($f480 = $node->filterXPath('//f480')) {
				$item['f480'] = $f480->text();
			}
			if ($f720 = $node->filterXPath('//f720')) {
				$item['f720'] = $f720->text();
			}
			if ($f1080 = $node->filterXPath('//f1080')) {
				$item['f1080'] = $f1080->text();
			}
			return $item;
		});
		return $items;
	}
}