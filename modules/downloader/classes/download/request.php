<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Description of request
 *
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Download_Request {

	public $url;
	public $addition_options = array();
	public $method = 'get';
	public $post_data = array();
	public $force_sets = array();
	public $user_agent;

	public function  __construct($url, $addition_options = array(), $force_sets = array()) {
		$this->url = $url;
		$this->addition_options = $addition_options;
		$this->force_sets = $force_sets;
	}
}