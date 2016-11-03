<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadCsvController extends Controller
{
    public function upload(Request $request){

    	$this->validate($request, [
    		'csv' => 'required|mimes:csv,txt' //have to use text here as well
		]);
    	if( file_exists( base_path('public/csv/source/posts.csv')) ){
    		unlink( base_path('/public/csv/source/posts.csv') );
    	}
    	$request->file('csv')->move(base_path('public/csv/source'), 'posts.csv');

    	return 'true';
    
    }
}
