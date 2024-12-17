<?php
class Order extends AbstractPost {

	protected $table = 'user_order';
	protected $key_field = false;
	function __construct($post) {
		parent::__construct($post);
		return $this;
	}

}