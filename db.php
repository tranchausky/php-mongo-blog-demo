<?php 

namespace Blog\DB;
//use MongoDB\Driver\Manager;

class DB {

	/**
	* Return db
	* @var object
	*/
	private $db;
	/**
	* Results limit.
	* @var integer
	*/
    public $limit = 5;

	
	public function __construct($config){

		$this->connect($config);	
	}

	private function connect($config){
		
		try{
			if ( !class_exists('MongoDB\Client')){
	            echo ("The MongoDB PECL extension has not been installed or enabled");
	            return false;
	        }
			//$connection=  new \MongoDB\Client($config['connection_string'],array('username'=>$config['username'],'password'=>$config['password']));
			$connection=  new \MongoDB\Client($config['connection_string']);
	    	//return $this->db = $connection->selectDB($config['dbname']);
	    	//return $this->db = $connection->blogpost->movie;
	    	return $this->db = $connection->blogpost;
		}catch(Exception $e) {
			return false;
		}
		
		/*
		 try {
			// connect to OVHcloud Public Cloud Databases for MongoDB (cluster in version 4.4, MongoDB PHP Extension in 1.8.1)
			$m = new MongoDB\Driver\Manager($config['connection_string']);
			//echo "Connection to database successfully";
			// display the content of the driver, for diagnosis purpose
			//var_dump($m);
			return $this->db = $m;
		}
		catch (Throwable $e) {
			// catch throwables when the connection is not a success
			echo "Captured Throwable for connection : " . $e->getMessage() . PHP_EOL;
		}
		*/
	}
	/**
	 * get one article by id
	 * @return array
	 */
	public function getById($id,$collection){
		// Convert strings of right length to MongoID
		if (strlen($id) == 24){
			//$id = new \MongoId($id);
			$id = new \MongoDB\BSON\ObjectId("$id");
		}
		$table = $this->db->selectCollection($collection);
		$cursor  = $table->find(array('_id' => $id));

        $article = [];
        foreach($cursor as $document){
            //var_dump($document);die;
            $article = iterator_to_array($document);
        }
		//$article = $cursor->getNext();
		

		if (!$article ){
			return false ;
		}
		return $article;
	}
	/**
	 * get all data in collection and paginator
	 *
	 * @return multi array 
	 */
	public function get($page,$collection){

		$currentPage = $page;
		$articlesPerPage = $this->limit;

		//number of article to skip from beginning
		$skip = ($currentPage - 1) * $articlesPerPage; 

		//var_dump($collection);die;
		//$table = $this->db->selectCollection($collection);
		//echo '1';
		$table = $this->db->$collection;
		//echo '2';
		$cursor = $table->find(
            [],
            [
               // 'limit' => 5,
                //'sort' => ['pop' => -1],
               // 'skip' => $skip
            ]
        );

       // $dataArr = $cursor->jsonSerialize();
		//var_dump($cursor);
		//var_dump($dataArr);die;
        //$jokesArray = iterator_to_array($cursor);
        //var_dump($jokesArray);die;

		
        $totalArticles = 0;
        //$results = [];
		foreach ($cursor as $document) {

            //$results[] = iterator_to_array($document);
            //var_dump($results);die;
            //var_dump($document);die;
            $totalArticles ++;
        }


        //$totalArticles = 0;
        $cursorLimit = $table->find(
            [],
            [
                'limit' => 5,
                //'sort' => ['pop' => -1],
                'skip' => $skip
            ]
        );

        $results = [];
		foreach ($cursorLimit as $document) {

            $results[] = iterator_to_array($document);
            //var_dump($results);die;
            //var_dump($document);die;
            //$totalArticles ++;
        }

		//echo 3;
		//die;
		//total number of articles in database
		//$totalArticles = $cursor->count(); 
		//total number of pages to display
		$totalPages = (int) ceil($totalArticles / $articlesPerPage); 

		//$cursor->sort(array('saved_at' => -1))->skip($skip)->limit($articlesPerPage);
		//$cursor = iterator_to_array($cursor);
		$data=array($currentPage,$totalPages,$results);

		return $data;
	}
	/**
	 * Create article
	 * @return boolean
	 */
	public function create($collection,$article){

		$table 	 = $this->db->selectCollection($collection);
        //var_dump($article);die;
		return $result = $table->insertOne($article);
	}
	/**
	 * delete article via id
	 * @return boolean
	 */
	public function delete($id,$collection){
		// Convert strings of right length to MongoID
		if (strlen($id) == 24){
			$id = new \MongoDB\BSON\ObjectId("$id");
		}
		$table 	 = $this->db->selectCollection($collection);
		$result = $table->deleteOne(array('_id'=>$id));
		if (!$id){
			return false;
		}
		return $result;

	}
	/**
	 * Update article
	 * @return boolean
	 */
	public function update($id,$collection,$article){
		// Convert strings of right length to MongoID
		if (strlen($id) == 24){
			//$id = new \MongoId($id);
            $id = new \MongoDB\BSON\ObjectId("$id");
		}
		$table 	 = $this->db->selectCollection($collection);
		$result  = $table->updateOne(
				array('_id' => new \MongoDB\BSON\ObjectId("$id")), 
				array('$set' => $article)
		);
		if (!$id){
			return false;
		}
		return $result;

	}
	/**
	 * create and update comment
	 * @return boolean
	 */
	public function commentId($id,$collection,$comment){
		
		$postCollection = $this->db->selectCollection($collection);
		$post = $postCollection->findOne(array('_id' => new \MongoDB\BSON\ObjectId("$id")));

		if (isset($post['comments'])) {
			$comments = iterator_to_array($post['comments']);
		}else{
			$comments = array();
		}
        //var_dump($comments);die;
		array_push($comments, $comment);

		return $postCollection->updateOne(
						array('_id' => new \MongoDB\BSON\ObjectId("$id")), 
						array('$set' => array('comments' => $comments))
		);
	}

}
