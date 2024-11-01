<?php

function wp_spatialtree_get_article_list($pageNum, $len) {
	$options = get_option('wp_spatialtree_options');
	if($options['username'] != '' && $options['password'] != '') {
		$response = wp_remote_post('http://api.spatialtree.com/api/getArticlesList', array(
				'method' => 'POST',
				'timeout' => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(),
				'body' => array('username' => $options['username'], 'password' => $options['password'], 'page' => $pageNum, 'len' => $len),
				'cookies' => array()
			)
		);
		if(is_wp_error($response)) {
			return false;
		} else {
			if(isset($response) && isset($response['body']) && $response['body'] != '') {
				$response = json_decode($response['body'], true);
				if($response[0]['authentication'] == 'failed') {
					return false;
				} else {
					return $response;
				}
			} else {
				return false;
			}
		}
	} else {
		return false;
	}
}

function wp_spatialtree_get_article_content($articleID = '') {
	$options = get_option('wp_spatialtree_options');
	if($options['username'] != '' && $options['password'] != '' && $articleID != '') {
		$response = wp_remote_post('http://api.spatialtree.com/api/getArticlesContent', array(
				'method' => 'POST',
				'timeout' => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(),
				'body' => array('username' => $options['username'], 'password' => $options['password'], 'id' => $articleID),
				'cookies' => array()
			)
		);
		if(is_wp_error($response)) {
			return false;
		} else {
			if(isset($response) && isset($response['body']) && $response['body'] != '') {
				$response = json_decode($response['body'], true);
				$error = '';
				switch (json_last_error()) {
					case JSON_ERROR_DEPTH:
						$error = 'Maximum stack depth exceeded';
					break;
					case JSON_ERROR_STATE_MISMATCH:
						$error = 'Underflow or the modes mismatch';
					break;
					case JSON_ERROR_CTRL_CHAR:
						$error = 'Unexpected control character found';
					break;
					case JSON_ERROR_SYNTAX:
						$error = 'Syntax error, malformed JSON';
					break;
					case JSON_ERROR_UTF8:
						$error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
					break;
				}
				if($error != '') {
					return $error;
				} else {
					if($response[0]['authentication'] == 'failed') {
						return false;
					} else {
						return $response;
					}
				}
			} else {
				return false;
			}
		}
	} else {
		return false;
	}
}

function wp_spatialtree_get_visualization_data_list() {
	$visualizations = array(
		array('title' => 'Entity 1', 'id' => '1'),
		array('title' => 'Entity 2', 'id' => '2'),
		array('title' => 'Entity 3', 'id' => '3'),
		array('title' => 'Entity 4', 'id' => '4'),
		array('title' => 'Entity 5', 'id' => '5'),
	);
	return $visualizations;
}

function wp_spatialtree_check_user() {
	$options = get_option('wp_spatialtree_options');
	if($options['username'] != '' && $options['password'] != '') {
		$response = wp_remote_post('http://api.spatialtree.com/api/checkUser', array(
				'method' => 'POST',
				'timeout' => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(),
				'body' => array('username' => $options['username'], 'password' => $options['password']),
				'cookies' => array()
			)
		);
        
        if(is_wp_error($response)){
            var_dump($response);
            return null;
        }
        else{
            $response = json_decode($response['body'], true);
            return $response;
        }
	}
}

?>