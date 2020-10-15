<?php

namespace App\Http\Controllers;

use App\Headings;
use App\Rfq;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
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
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index()
    {
        return view('admin.index');
    }

    public function getRFQ(){
        return view('admin.rfq');
    }

    public function tables(Request $request)
    {
        if ($request->ajax()) {
            $data = Headings::latest()->whereBetween('fk_hs_code', [50, 63])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('headings_image', function ($row) {
                    if (!empty($row->headings_image)) {
                        return '<img src="' . URL::asset('thumbnail') . '/' . $row->headings_image . '" alt="">';
                    } else {
                        return '<img src="https://dummyimage.com/100x100/aeb2eb/fff.jpg&text=Image+Not+found">';
                    }
                })
                ->addColumn('action', function ($row) {

                    return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" onclick="edit_image_modal(' . $row->id . ')">Edit Image</a>';
                })
                ->rawColumns(['action', 'headings_image'])
                ->make(true);
        }
    }

    public function rfqTables(Request $request){
        if ($request->ajax()) {
            $rfq = Rfq::latest()->get();
            return Datatables::of($rfq)
                ->addIndexColumn()
                ->addColumn('rfq_description', function ($row) {
                    if (!empty($row->rfq_description)) {
                        return str_limit($row->rfq_description, 100, '...');
                    }
                })
                ->addColumn('view', function ($row) {
                    return '<a href="javascript:void(0)" class="btn btn-primary btn-sm viewRFQsingle" data-ids="' . $row->id . '">view</a>';
                })
                ->rawColumns(['view'])
                ->make(true);
        }
    }
    public function rfqSingle(Request $request){
        if ($request->ajax()) {
            $rfqSingle = Rfq::where('id',$request->id)->firstOrfail();
            echo json_encode($rfqSingle);
        }
    }

    public function resizeImagePost(Request $request)
    {
        if ($request->ajax()) {
            $this->validate($request, [
                'headings_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $headings_id = $request->input('headings_id');
            $image = $request->file('headings_image');
            $input['image_name'] = md5_file($image) . '-' . time() . '.' . $image->getClientOriginalExtension();
            try {

                $img = Image::make($image->getRealPath());

                $destinationPath = public_path('/headings_images');
                $return = $img->fit(250, 250, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $input['image_name']);

                $img = Image::make($image->getRealPath());
                $destinationPath = public_path('/thumbnail');
                $img->fit(100)->save($destinationPath . '/' . $input['image_name']);
                if ($return) {
                    $headings = Headings::where('id', $headings_id)
                        ->first();
                    $oldImage = public_path('/headings_images') . '/' . $headings->headings_image;
                    $oldThumbnail = public_path('/thumbnail') . '/' . $headings->headings_image;
                    $headings->headings_image = $input['image_name'];
                    if ($headings->save()) {
                        $files = array($oldImage, $oldThumbnail);
                        File::delete($files);
                        echo 'success';
                    }
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
