<?php
class Users extends AbstractPosts {

	protected $table = 'user';

	function setupData() {
		$new_posts = [];
		foreach ($this->posts as $post) {
			$new_posts[] = new User($post);
		}
		$this->posts = $new_posts;

		return $this;
	}

}