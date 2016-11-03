<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Csv\Writer;
use \App\Utilities\Helpers;
use \App\Utilities\Json_Encode;

class PostsCsvController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		return view('index');

	}


	public function topPostsDownload(Request $request)
	{

		$helpers = new Helpers;
		$top_post_results = $helpers->getTopPosts();
		$value = $request->input('json');

		if( $value == 'yes' ){

			$encode = new Json_Encode;
			$json_value =  $encode->safe_json_encode($top_post_results);
			echo $json_value;

		} else {

			$top_posts_object = Writer::createFromFileObject( new \SplTempFileObject() );
			$top_posts_object->insertOne('id');
			$top_posts_object->insertAll($top_post_results);
			$top_posts_object->output( 'top_posts.csv' );

		}

	}

	
	public function notTopPostsDownload(Request $request)
	{
	
		$helpers = new Helpers;
		$remaining_posts_results = $helpers->getRemaingingPosts();
		$value = $request->input('json');

		if( $value == 'yes' ){

			$encode = new Json_Encode;
			$json_value =  $encode->safe_json_encode($remaining_posts_results);
			echo $json_value;

		} else {

			$remaining_posts_object = Writer::createFromFileObject( new \SplTempFileObject() );
			$remaining_posts_object->insertOne('id');
			$remaining_posts_object->insertAll($remaining_posts_results);
			$remaining_posts_object->output( 'remaining_posts.csv' );

		}

	}

	public function dailyTopPostsDownload(Request $request){

		$helpers = new Helpers;
		$daily_top_post_result = $helpers->getDailyTopPosts();
		$value = $request->input('json');

		if( $value == 'yes' ){

			$encode = new Json_Encode;
			$json_value =  $encode->safe_json_encode($daily_top_post_result);
			echo $json_value;

		} else {

			$daily_top_post_object = Writer::createFromFileObject( new \SplTempFileObject() );
			$daily_top_post_object->insertOne(['id', 'title', 'privacy', 'likes', 'views', 'comments', 'original-timestamp', 'processed-timestamp']);
			$daily_top_post_object->insertAll($daily_top_post_result);
			$daily_top_post_object->output( 'daily_top_posts.csv' );

		}
	
	}
}
