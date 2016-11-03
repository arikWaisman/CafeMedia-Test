<?php

namespace App\Utilities;

use Carbon\Carbon;
use League\Csv\Reader;

class Helpers
{

	private $top_posts_results = [];

	private $remaining_posts_results = [];

	private $daily_top_posts = [];

	public function __construct(){

		$this->loopThroughCSV(); 

	}

	public function loopThroughCSV(){

		$csv = Reader::createFromPath( base_path('csv/source/posts.csv') );
		$offset = 0; //this will use the first row as the keys in each Assoc Array
        $csvRows = $csv->fetchAssoc($offset);

         foreach($csvRows as $row){
         	
         	//check if post is the daily top post based on likes and add to array
        	$this->checkForDailyTopPosts($row);

			//check if top post or remaining post and add to respective array to be returned
            if( $this->checkForTopPosts($row) ){
            	
            	$this->top_post_results[] = $row['id'];

            } else {

            	$this->remaining_posts_results[] = $row['id'];

            }

     	}
       
	}

	public function checkForTopPosts(array $post){
			
			if($post['privacy'] == 'private'){
				return false;
			}

			if( (int)$post['comments'] <= 10){
				return false;
			}

			if( (int)$post['views'] <= 9000){
				return false;
			}

			if( (int)$post['views'] <= 9000){
				return false;
			}

			if( strlen($post['title']) > 40){
				return false;
			}

			return true;
	}

	public function checkForDailyTopPosts($row){

		$carbon = new Carbon();
     	$time = $carbon->parse( substr($row['timestamp'], 3))->toDateString()	;  
     	$row['timestamp-mdY'] = $time;
 
 		$comparator = 0;
		//is the array aware of the timestamp (does the array have a key with the iteration row[timestamp] value)?
		if (array_key_exists( $row['timestamp-mdY'], $this->daily_top_posts) ) {
			// if so, let's grab the row set for the current date and check the number of likes, that will be our new comparator
			$comparator = $this->daily_top_posts[$row['timestamp-mdY']]['likes'];
		}
		
		//this will be true in 2 circumstances, the $daily_top_posts array has not seen this date yet (so the $comparator is still 0) or if it has seen the date AND the current row's likes are higher than the previous high for that date.
		if ($row['likes'] > $comparator){
			//if that's the case, let's set the daily top posts[date] top post to the current $row
			$this->daily_top_posts[$row['timestamp-mdY']] = $row;
		}

	}

	public function getTopPosts(){
		
		return $this->top_post_results;
	
	}

	public function getRemaingingPosts(){
		
		return $this->remaining_posts_results;
	
	}

	public function getDailyTopPosts(){
		
		return $this->daily_top_posts;
	
	}

}