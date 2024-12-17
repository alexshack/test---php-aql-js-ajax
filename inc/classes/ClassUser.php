<?php
class User extends AbstractPost {

	protected $table = 'user';
	protected $key_field = 'id';

	function __construct($post) {
		parent::__construct($post);
        $this->post->name = $this->post->second_name . ' ' . $this->post->first_name;
		return $this;
	}

    public function getOrders() {
        $db = (new MyDB())->db;

        $sql = 'SELECT * FROM user_order INNER JOIN products ON user_order.product_id = products.id WHERE user_order.user_id = ' . $this->ID . ' ORDER BY products.title ASC, products.price DESC';

        $result = mysqli_query($db, $sql);
        $posts = [];
        while ($row = mysqli_fetch_object($result)) {
            $posts[] = $row;
        }

        mysqli_close($db);

        return $posts;
    }
}