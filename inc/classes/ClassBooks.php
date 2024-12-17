<?php
class Books extends AbstractPosts {

	protected $table = 'books';

	function setupData() {
		$new_posts = [];
		foreach ($this->posts as $post) {
			$new_posts[] = new Book($post);
		}
		$this->posts = $new_posts;

		return $this;
	}

}