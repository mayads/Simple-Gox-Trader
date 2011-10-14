<?php
/**
 * Mt.Gox DataSource
 *
 * Used for reading and writing to Mt.Gox, through models.
 *
 */
App::uses('HttpSocket', 'Network/Http');

class MtgoxSource extends DataSource {

    // TODO
    protected $_schema = array();
    
    private $__key;
    private $__secret;

    public function __construct($config) {
        $this->connection = new HttpSocket(
            "https://mtgox.com/api/"
        );
	
	$this->__key = $config['key'];
	$this->__secret = $config['secret'];
	
//	$this->connection->
	
	parent::__construct($config);
    }
    
    // TODO
    public function listSources() {
        return array('mtgox');
    }
    
    public function read($model, $queryData = array()) {
        //
	// generate a nonce as microtime, with as-string handling to avoid problems with 32bits systems
	$mt = explode(' ', microtime());
	$req['nonce'] = $mt[1].substr($mt[0], 2, 6);

	// generate the POST data string
	$post_data = http_build_query($queryData['req'], '', '&');

	// generate the extra headers
	$headers = array(
	    'Rest-Key: '.$this->__key,
	    'Rest-Sign: '.base64_encode(hash_hmac('sha512', $post_data, base64_decode($this->__secret), true)),
	    'User-Agent' => 'Mozilla/4.0 (compatible; MtGox PHP client; '.php_uname('s').'; PHP/'.phpversion().')'
	);
	
	$this->connection->config = array('header' => $headers );
	$this->connection->get( $queryData['path'], $post_data );
	//
	
	if (!isset($queryData['conditions']['username'])) {
            $queryData['conditions']['username'] = $this->config['login'];
        }
        $url = "/statuses/user_timeline/";
        $url .= "{$queryData['conditions']['username']}.json";

        $response = json_decode($this->connection->get($url), true);
        $results = array();

        foreach ($response as $record) {
            $record = array('Tweet' => $record);
            $record['User'] = $record['Tweet']['user'];
            unset($record['Tweet']['user']);
            $results[] = $record;
        }
        return $results;
    }
    
    public function create($model, $fields = array(), $values = array()) {
        $data = array_combine($fields, $values);
        $result = $this->connection->post('/statuses/update.json', $data);
        $result = json_decode($result, true);
        if (isset($result['id']) && is_numeric($result['id'])) {
            $model->setInsertId($result['id']);
            return true;
        }
        return false;
    }
    
    /*
    public function describe($model) {
        return $this->_schema['tweets'];
    } 
    */
}