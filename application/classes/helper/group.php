<?php

defined('SYSPATH') or die('No direct script access.');

class Helper_Group
{
	private $money_earned;
	private $partner_group_id;

	public function __construct($money_earned, $partner_group_id) 
	{
		$this->money_earned = $money_earned;
		$this->partner_group_id = $partner_group_id;
	}
	public function get_percentage_filled()
	{
		if ($this->partner_group_id == 3) return '100%';
		if ($this->partner_group_id == 1) return $this->money_earned / 25000 * 100 . '%';
		if ($this->partner_group_id == 2) return ($this->money_earned - 25000) / 25000 * 100 . '%';
	}
	public function get_remaining()
	{
		if ($this->partner_group_id == 3) return '';
		if ($this->partner_group_id == 1) return 25000 - $this->money_earned;
		if ($this->partner_group_id == 2) return 50000 - $this->money_earned;
	}
}