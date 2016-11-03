<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">

        <title>CafeMedia Test</title>
    </head>
    <body>
        <div class="container-fluid cafe-media-test">
            <div class="row">
                <div class="col-md-10 col-md-push-1 text-center">
                    <h1>
                        CafeMedia Test
                    </h1>
                </div>
            </div>

            <div class="col-md-10 col-md-push-1 form-wrapper">

                @if( File::exists( base_path('csv/source/posts.csv') ) )
                    <h3 class="alert alert-success text-center">A CSV Exists! to overwrite re-upload</h3>
                @endif

                    <form id="upload_file_form" class="col-xs-12">
                        <div class="form-group">
                            <h3>Upload a CSV to parse</h3><button id="top-post-download" type="submit" class="btn btn-primary">Upload</button>
                            <input id="upload_file" type="file" name="csv" accept=".csv"> 
                        </div>
                        {{ csrf_field() }}
                    </form>
                

                <form  class="col-xs-12" method="post" action="{{ route('topPosts') }}">
                    <div class="form-group">
                         <h3>Download All Top Posts:</h3><button id="top-post-download" type="submit" class="btn btn-primary">Download</button>
                         <div class="json-encoded form">
                             Would you prefer JSON data rather than a CSV file?
                             <select name="json">
                                 <option value="yes">yes</option>
                                 <option value="no" selected>no</option>
                             </select>
                         </div>
                    </div>
                        {{ csrf_field() }}
                </form>
                <form  class="col-xs-12" method="post" action="{{ route('dailyTopPosts') }}">
                    <div class="form-group">
                         <h3>Download Daily Top Posts:</h3><button id="top-post-download" type="submit" class="btn btn-primary">Download</button>
                        <div class="json-encoded form">
                             Would you prefer JSON data rather than a CSV file?
                             <select name="json">
                                 <option value="yes">yes</option>
                                 <option value="no" selected>no</option>
                             </select>
                         </div>
                    </div>
                        {{ csrf_field() }}
                </form>
                <form class="col-xs-12" method="post" action="{{ route('NotTopPosts') }}">
                    <div class="form-group">
                        <h3>Download All Remaining Posts:</h3><button id="not-top-post-download" type="submit" class="btn btn-primary">Download</button>
                        <div class="json-encoded form">
                             Would you prefer JSON data rather than a CSV file?
                             <select name="json">
                                 <option value="yes">yes</option>
                                 <option value="no" selected>no</option>
                             </select>
                         </div>
                    </div>
                    {{ csrf_field() }}

                </form>
            </div>
        </div>
        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
        <script>
         var baseURL = '{{ URL::to('/') }}';
         var token = '{{ csrf_token() }}';
        </script>
    </body>
</html>
