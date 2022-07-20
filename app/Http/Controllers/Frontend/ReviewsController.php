<?php

namespace App\Http\Controllers\Frontend;
/**
 * :: Reviews Controller ::
 * To manage lecture.
 *
 **/
use App\Models\Review;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewsFrontController extends  Controller{
  
    public function store_review(Request $request)
    {
        $request['user_id'] = Auth::id();
        $inputs = $request->all();

        try {

              $validator = (new Review)->validate_front($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }

             if(isset($inputs['image']) or !empty($inputs['image']))
            {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('image')) 
                {
                    $file = $request->file('image') ;
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/review_images/' ;
                    $file->move($destinationPath, $fileName);
                }

                $image = $fileName;
            }
            else{
                $image = null;
            }

            unset($inputs['image']);     

            $inputs = $inputs + [
                    'status'    => 0,
                    'image' => $image,
                    'created_by' => Auth::id(),
                    'user_id' => Auth::id(),
                ];  

            (new Review)->store($inputs);

            return redirect()->back()
                ->with('success_review', lang('messages.created', lang('blogs.blogs')));
        } catch (\Exception $exception) {
     
            return redirect()->back()
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }

   
}