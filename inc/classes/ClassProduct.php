<?php
class Product extends AbstractPost {

	protected $table = 'products';
	protected $key_field = 'id';

	function __construct($post) {
		parent::__construct($post);
		return $this;
	}

}