<?php
class Orders extends AbstractPosts {

	protected $table = 'user_order';

	function setupData() {
		$new_posts = [];
		foreach ($this->posts as $post) {
			$new_posts[] = new Order($post);
		}
		$this->posts = $new_posts;

		return $this;
	}

}