<?php
abstract class AbstractPost {
	protected $table;
	protected $key_field;
	protected $file_fields = [];
	protected $bool_fields = [];
	public $post;
	public $ID = false;

	function __construct( $post ) {
		if ( is_object( $post ) ) {
			$this->post = $post;
		} else {
			if ( is_array($post) ) {
				if ( $this->key_field && isset( $post['post'][ $this->key_field ] ) ) {
					$this->post = $this->updateRow( $this->getFields($post) );
				} else {
					$this->post = $this->insertRow( $this->getFields($post) );
				}
			} else {
				$this->post = $this->getRow($post);
			}
		}

		if ($this->key_field) {
            $this->ID = $this->post->{$this->key_field};
        }
	}


	protected function getRow( $id ) {

        $db = (new MyDB())->db;

        $id = (int) $id;

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->key_field . ' = ' . $id;

		$result = mysqli_query( $db, $sql );

		$post = mysqli_fetch_object( $result );

        mysqli_close( $db );

		return $post;
	}

	protected function updateRow( $fields ) {
        $db = (new MyDB())->db;

		$id = $fields[$this->key_field];
		unset( $fields[$this->key_field] );

		$set_array = [];

		foreach ( $fields as $key => $value ) {
			$set_array[] = $key . '="' . mysqli_real_escape_string( $db, $value ) . '"';
		}

		$set = implode(', ', $set_array );

		$sql = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE ' . $this->key_field . '=' . $id;

		$result = mysqli_query( $db, $sql );

        mysqli_close( $db );

		if ( $result ) {
			return $this->getRow( $id );
		} 

		return false;
	}

	protected function insertRow( $fields ) {

        $db = (new MyDB())->db;

        $fields_array = [];
		$values_array = [];

		foreach ( $fields as $key => $value ) {
			$fields_array[] = $key;
			if ( is_numeric( $value ) ) {
				$values_array[] = $value;
			} else {
				$values_array[] = "'" . mysqli_real_escape_string( $db, $value ) . "'";
			}
		}

		$fields = implode(', ', $fields_array);
		$values = implode(', ', $values_array);

		$sql = 'INSERT INTO ' . $this->table . ' (' . $fields . ') VALUES (' . $values . ')';

		$result = mysqli_query($db, $sql);

        if ( $result && $this->key_field ) {
            $row = $this->getRow( $db->insert_id );
            mysqli_close($db);
			return $row;
		}
        mysqli_close($db);
		return false;
	}
    function deleteRow() {
        $db = (new MyDB())->db;

        $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->key_field . ' = ' . $this->ID;
        $result = mysqli_query($db, $sql);
        mysqli_close($db);
        if ( $result ) {
            return true;
        }
        return false;
    }

	public function getPost() {
		return $this->post;
	}	

	function getFields( $data ) {
    
		foreach ( $this->file_fields as $file_field => $file_path ) {

			if ( isset( $data['files'][$file_field]['tmp_name'] ) && $data['files'][$file_field]['tmp_name'] !='' ) {
				
				$data['post'][$file_field] = $this->getMedia( $data['files'], $file_field );

			} else {
				if ( isset($data['post'][$file_path]) ) {
					$data['post'][$file_field] = $data['post'][$file_path];
					unset( $data['post'][$file_path] );
				}
			}
		}

		foreach ( $this->bool_fields as $bool_field ) {

			if ( isset( $data['post'][$bool_field] ) ) {
				$data['post'][$bool_field] = 1;
			} else {
				$data['post'][$bool_field] = 0;
			}

		}

		return $data['post'];
	}


	function getMedia( $files, $field ) {
    
	    if ( isset( $files[$field]['tmp_name'] ) ) {
	        $md5 = md5( time() . rand(1,9999) );
	        $ext = explode( '.', $files[$field]['name'] );
	        $ext = $ext[( count($ext)-1 )];
	        copy( $files[$field]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/media/' . $md5 . '.' . $ext );
	        return '/media/' . $md5 . '.' . $ext;
	    }
	    
	    return '';

	}

}