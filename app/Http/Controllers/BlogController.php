<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $users = User::get();
        $pagetitle   = "Blog Data from API";
        $breadcrumbs = ["Dashboard", "Blog Data from API"];
        $urls        = ['/', 'blogs/'];
        return view('blogs.index', compact('pagetitle', 'breadcrumbs', 'urls'));
    }

    public function ajax_data_request(Request $request)
    {
        if($request->action == "get_blogs"){

            //Getting data from URL using CURL
            $url = "https://api.publicapis.org/entries";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response, true);
            $data_enteries = $response['entries'];

            //Inserting Data into Database
            if($data_enteries){
                foreach($data_enteries as $entery){
                    //Check Record already exist or not on the bases of Link , API and Category As these are unique in data
                    $blog_isExist = Blog::where('api',$entery['API'])
                    ->where('category',$entery['Category'])
                    ->where('link',$entery['Link'])
                    ->first();
                    if(!$blog_isExist)
                    {
                        
                        $blog= new Blog();
                        $blog->api          = $entery['API'];
                        $blog->description  = $entery['Description'];
                        $blog->auth         = $entery['Auth'];
                        $blog->https        = $entery['HTTPS'];
                        $blog->cors         = $entery['Cors'];
                        $blog->link         = $entery['Link'];
                        $blog->category     = $entery['Category'];
                        $is_save = $blog->save();
                    }
                }
            }  
            $data = Blog::orderBy('id', 'desc')->get();
            //Returing Data Array to DataTable
            return DataTables::of($data)
            ->editColumn('description', function ($data) {
                $Description = $data->description;
                if(strlen($Description) > 50 ){
                    $Description = trim($Description);
                    $Description = mb_substr($Description,0,50)."..";
                    return '<div class="btn-toolbar" title="'.strip_tags($data->description).'">'.$Description .'</div>';
                }
                return $Description;
            })
            ->editColumn('auth', function ($data) {
                $auth = $data->auth;
                if($auth!=""){
                    $auth = ucfirst($auth);
                }
                return $auth;
            })
            ->editColumn('cors', function ($data) {
                $cors = $data->cors;
                if($cors!=""){
                    $cors = ucfirst($cors);
                }
                return $cors;
            })
            ->editColumn('link', function ($data) {
                $Link = $data->link;
                $link_path = '<a class="me-3 text-default " data-bs-custom-class="custom-tooltip" data-toggle="tooltip"
                data-bs-placement="bottom" data-toggle="tooltip" title="'.$Link.'" target="_blank" href="'.$Link.'">'.$Link.'</a>';
                return $link_path;
            })
            ->rawColumns(['description','link','auth','cors'])
            ->make(TRUE);

        }
    }
}
