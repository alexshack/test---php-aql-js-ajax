<?php
class Products extends AbstractPosts {

	protected $table = 'products';

	function setupData() {
		$new_posts = [];
		foreach ($this->posts as $post) {
			$new_posts[] = new Product($post);
		}
		$this->posts = $new_posts;

		return $this;
	}




}