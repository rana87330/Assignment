<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Validator;

class ImportUserController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pagetitle   = "Import Users";
        $breadcrumbs = ["Dashboard", "Import Users"];
        $urls        = ['/', 'users/'];
        return view('users.index', compact('pagetitle', 'breadcrumbs', 'urls'));
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request) 
    {
        if ($request->file) 
        {
            $file = $request->file;
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes
            //Checks to see that the valid file types and sizes were uploaded
            $this->checkUploadedFileProperties($extension, $fileSize);
            
            $messages = [
                'file.required'    => 'Excel File Is Required',
                'file.max'         => 'Maximum size allowed is 2048',
                'file.mimes'       => 'Please upload xlsx or csv files',
                'file.required'    => 'Excel File Is Required',
                'file.required'    => 'Please select any project',
            ];
            
            
            $validator= Validator::make($request->all(), [ 
                'file'=> 'required|mimes:xlsx,csv|max:2048',
                ],$messages);

            if ($validator->fails()){
                return redirect('users/')
                ->withErrors($validator)
                ->withInput();
            }

            // if($request->hasFile('file'))
            // {
            //     $file = $request->file('file');
            //     $destination_path = 'public/import/files';
            //     $filename = $this->roboFileUpload($file, $destination_path, $batch_id);
            // }
            $import = new UserImport();
            Excel::import($import,request()->file('file'));
            $arr = $import->getInsertRecord();
            return redirect('users')->with("arr",$arr);

            //Return a success response with the number if records uploaded
            return response()->json([
            'message' => $import->data->count() ." Records successfully uploaded"
            ]);
        } 
        else 
        {
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }

    public function checkUploadedFileProperties($extension, $fileSize) : void
    {
        $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) 
        {
            if ($fileSize <= $maxFileSize) {} 
            else 
            {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } 
        else 
        {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }

    public function ajax_data_request(Request $request)
    {
        if($request->action == "get_users"){

            //Getting Data from User Table in Database
            //Note : we could remove get() function while using Yajra
            $users = User::where('active','Yes')->orderBy('id', 'desc')->get();
            //Returing Data Array to DataTable
            return DataTables::of($users)
            ->editColumn('address', function ($users) {
                $address = $users->address;
                if(strlen($address) > 15 ){
                    $address = trim($address);
                    $address = mb_substr($address,0,13)."..";
                    return '<div class="btn-toolbar" title="'.strip_tags($users->address).'">'.$address .'</div>';
                }
                return $address;
            })
            ->rawColumns(['address'])
            ->make(TRUE);

        }
    }
}
