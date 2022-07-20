<?php

namespace App\Http\Controllers\Frontend;
/**
 * :: Homepage Controller ::
 * To manage homepage.
 *
 **/
Use Mail;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;
use App\Models\ContentManagement;
use App\Models\Offer;
use App\Models\Cart;
use App\Models\InstructionVideo;
use App\Models\Tradeshow;
use App\Models\Ecatalog;
use App\Models\Contact;
use App\Models\Order;
use App\Models\LoginLog;
use App\Models\Subscriber;
use App\Models\Category;
use App\Models\OrderProduct;
use App\User;
use Ixudra\Curl\Facades\Curl;
use App\Models\Faqs;
use Session;
use Redirect;
use ElfSundae\Laravel\Hashid\Facades\Hashid;
use PDF;
use Auth;
use App\PasswordHash;
// use Stevebauman\Location\Facades\Location;

class HomeController extends Controller{

    public function __construct(Guard $auth, User $registrar)
    {
        $this->auth = $auth;
        //$this->middleware('guest', ['except' => 'getLogout']);
    }

    public function tradeshows(){
      try {
          $today = date('Y-m-d');
          $tradeshows =  Tradeshow::where('status', 1)->select('name', 'place', 'booth', 'to_date', 'from_date')->where('from_date', '>=', $today)->orderby('from_date', 'ASC')->get();
          $Categorys = Category::where('status', 1)->select('name', 'id', 'url')->get();
          return view('frontend.pages.tradeshow', compact('tradeshows', 'Categorys'));
      } catch (\Exception $exception) {
          return back();
        }
    }

    public function forms_page(){
        return view('frontend.pages.forms_page');
    }

    public function e_catalogs(){
      try {

        $catalogs_2022 = Ecatalog::where('status', 1)->where('category', 1)->select('title', 'background_image', 'catalog_file', 'url')->get();

        $speciality_catalogs = Ecatalog::where('status', 1)->where('category', 0)->select('title', 'background_image', 'catalog_file', 'url')->get();

        return view('frontend.pages.e_catalog', compact('catalogs_2022', 'speciality_catalogs'));
      } catch (Exception $e) {
        return back();
      }
    }

    public function closeouts(){
      try{
          $products = Product::where('status', 1)->where('closeout', 1)->select('id', 'name', 'url', 'quantity', 'offer_price', 'regular_price', 'thumbnail')->orderby('id', 'desc')->paginate(30);
          $counts = Product::where('status', 1)->where('closeout', 1)->select('id')->count();
          $Categorys = Category::where('status', 1)->select('name', 'id', 'url')->get();
          return view('frontend.pages.closeouts', compact('products', 'Categorys', 'counts'));
      } catch (Exception $e) {
        return back();
      }
    }

    public function order_form(){
      try {
            return view('frontend.pages.order_form');
      } catch (Exception $e) {
        return back();
      }
    }
    public function independent_sales(){
      try {
            return view('frontend.pages.independent_sales');
      } catch (Exception $e) {
        return back();
      }
    }
    public function credit_card_authorization(){
      try {
            return view('frontend.pages.credit_card_authorization');
      } catch (Exception $e) {
        return back();
      }
    }
    public function credit_terms_application(){
      try {
            return view('frontend.pages.credit_terms_application');
      } catch (Exception $e) {
        return back();
      }
    }
    public function credit_reference_form(){
      try {
            return view('frontend.pages.credit_reference_form');
      } catch (Exception $e) {
        return back();
      }
    }
    public function n30_agreement(){
      try {
            return view('frontend.pages.n30_agreement');
      } catch (Exception $e) {
        return back();
      }
    }
    public function personal_guarantee_letter(){
      try {
            return view('frontend.pages.personal_guarantee_letter');
      } catch (Exception $e) {
        return back();
      }
    }

    public function index() {
    try  {
      $sliders = Slider::where('status', 1)->where('show_in_web', 1)->select('image', 'title', 'link', 'app_slider')->get();
      $new_products = Product::where('status', 1)->where('trending', 0)->select('id', 'name', 'url', 'quantity', 'offer_price', 'regular_price', 'thumbnail')->limit(20)->orderby('id', 'desc')->get();
      $categories = Category::where('status', 1)->where('parent_id', NULL)->where('image', '!=', '/uploads/category_images/no_img.jpg')->where('id', '!=', 13)->select('id', 'name', 'url', 'image')->orderby('order', 'asc')->get();
      $trending_products = Product::where('status', 1)->where('trending', 1)->select('id', 'name', 'url', 'quantity', 'offer_price', 'regular_price', 'thumbnail')->limit(20)->orderby('id', 'desc')->get();  
      //dd($new_products);
 
      return view('frontend.home', compact('sliders', 'new_products', 'categories', 'trending_products'));
    } catch (\Exception $exception) {
      //dd($exception);
            return back();
        }
    }

    public function instruction_videos(){
      try{

          $instruction_videos = InstructionVideo::where('status', 1)->select('name', 'iframe_code')->get();
          return view('frontend.pages.instruction_videos', compact('instruction_videos'));

      } catch (\Exception $exception) {
        //dd($exception);
          return back();
      }
    }



    public function subscriberStore(Request $request) {
      try {
        
       // dd($request);
        $data['already_subs'] = "";  
        $data['email_subs'] = "";
        $data['valid_email'] = "";
        $inputs = $request->all(); 
        $validator = (new Subscriber)->validate($inputs);
        if($validator->fails()) {
      //   dd($validator);
          $data['valid_email'] = "Enter a valid email address";
           return $data;
        } 

        $chk_subs = Subscriber::where('email', $request->email)->first();
        if($chk_subs){
          $data['already_subs'] = "You’re Already Subscribed!";
        } else {
          Subscriber::create(['email' => $request->email]);
          $data['email_subs'] = "Thank you for your subscription";
        }

       return $data;

    } catch(\Exception $exception) {
        //dd($exception);
            return back();
    }
    }


      public function postLogin(Request $request) {
        try{
        $credentials = [
            'email' => $request->get('username'),
            'password' => $request->get('password'),
            'status' => 1
        ];

        $credentials1 = [
            'mobile' => $request->get('username'),
            'password' => $request->get('password'),
            'status' => 1
        ];
          
          $ip = $request->getClientIp();
          $inputs = $request->all();
        
            $validator = (new User)->validateLoginUser($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }

          $user = User::where('email', $request->username)->where('status', 1)->select('password')->first(); 
          if($user){
          $wp_hasher = new PasswordHash(8, TRUE);
          $plain_password = $request->password; 
          $password_hashed  =  $user->password;

          if($wp_hasher->CheckPassword($plain_password, $password_hashed)) {
            $user = User::where('email', $request->username)->where('status', 1)->first(); 
          } else {
            $user = ''; 
          }
          }

            if (!empty($user))  {

                \Auth::login($user);
                $session_id = $_SERVER['HTTP_USER_AGENT'];
                Cart::where('session_id', $session_id)
                       ->update([
                      'session_id' =>  NULL,
                      'user_id'  => $user->id,
                ]);

                $LoginLog = new LoginLog();
                $LoginLog->username = $request->username;
                $LoginLog->is_login = 1;
                $LoginLog->user_id = $user->id;
                $LoginLog->ip = $ip;
                $LoginLog->save();       
           
                $redirectTo = \Session::get('redirect_url');
                 if($redirectTo){
                   return Redirect::to('/'.$redirectTo);
                } else {
                    return redirect()->route('home');
                }

          } else if (Auth::attempt($credentials))  {
       
                $user_data = User::where('email', $request->username)->first();

                \Auth::login($user_data);
                $session_id = $_SERVER['HTTP_USER_AGENT'];
                Cart::where('session_id', $session_id)
                       ->update([
                      'session_id' =>  NULL,
                      'user_id'  => $user_data->id,
                ]);

                $LoginLog = new LoginLog();
                $LoginLog->username = $request->username;
                $LoginLog->is_login = 1;
                $LoginLog->user_id = $user_data->id;
                $LoginLog->ip = $ip;
                $LoginLog->save();       
           
                $redirectTo = \Session::get('redirect_url');
                 if($redirectTo){
                   return Redirect::to('/'.$redirectTo);
                } else {
                    return redirect()->route('home');
                }

          } else if(Auth::attempt($credentials1)) {
               $user_data = User::where('mobile', $request->username)->first();

                 \Auth::login($user_data);
                 $session_id = $_SERVER['HTTP_USER_AGENT'];
                Cart::where('session_id', $session_id)
                       ->update([
                      'session_id' =>  NULL,
                      'user_id'  => $user_data->id,
                ]);

                $LoginLog = new LoginLog();
                $LoginLog->username = $request->username;
                $LoginLog->is_login = 1;
                $LoginLog->user_id = $user_data->id;
                $LoginLog->ip = $ip;
                $LoginLog->save();

                $redirectTo = \Session::get('redirect_url');
                if($redirectTo){
                  return Redirect::to('/'.$redirectTo);
                } else {
                    return redirect()->route('home');
                }
        } else {
      
          $LoginLog = new LoginLog();
          $LoginLog->username = $request->username;
          $LoginLog->is_login = 0;
          $LoginLog->ip = $ip;
          $LoginLog->save();

          return back()->with('failed_login', 'failed_login');
        }
              
    } catch(\exception $ex){
          // dd($ex);
            return back();
          }
    }

    public function save_user(Request $request){

      try{
         
          $inputs = $request->all();
          $validator = (new User)->validate_front($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
          }
          $inputs['name'] = $request->first_name .' '.$request->last_name;
          $password = \Hash::make($inputs['password']);
          unset($inputs['password']);
          $inputs['password'] = $password;
          $inputs['user_type'] = 2;
          $inputs['status'] = 0;
          $user_id = (new User)->store($inputs);

            $user_data = User::where('id', $user_id)->first();
            // \Auth::login($user_data);
            $data['id'] = $user_data;
            $data['name'] = $inputs['name'];    
            $data['email']  = $inputs['email'];
            $data['mobile']  = $inputs['mobile']; 
            $email = $inputs['email'];
            \Mail::send('email.user_verify', $data, function($message) use ($email){
                $message->from('no-reply@pukacreations.com');
                $message->to($email);
                $message->subject('Register');
            }); 
           // return redirect()->route('home');
            return redirect()->back()->with('message_reg', 'Register Done!');
        } catch(\Exception $ex){
      //   dd($ex);
          return back();
        }
    }


    public function Login() {
        return view('frontend.pages.login');
    }

    public function updatePassword($user_id) {
        $user_id = Hashid::decode($user_id);
        return view('frontend.pages.change_password', compact('user_id'));
    }


     public function priceFilter(Request $request)
    {
     try {
    $request->validate([
    'min' => 'required|max:255',
    'max' => 'required|max:255',
    ]);
    $inputs = $request->all();
   
      $products = \DB::table('products')
      ->select('thumbnail', 'name', 'id', 'url', 'product_type')
      ->where('product_lots.sale_price', '>=', $request->min)
      ->where('product_lots.sale_price', '<=', $request->max)
      ->where('products.status', 1)
      ->get();

      $count = \DB::table('products')
      ->join('product_lots', 'product_lots.product_id', '=', 'products.id')
      ->select('products.name as name')
      ->where('product_lots.sale_price', '>=', $request->min)
      ->where('product_lots.sale_price', '<=', $request->max)
      ->where('products.status', 1)
      ->count();

       $page = $request->page;
        if($request->page == 'Category'){
          $goal = Category::where('id', $request->f_id)->first();
        }
    // dd($products);
       
         return view('frontend.pages.filter.price_range', compact('products', 'request', 'count'));
    }
 catch(Exception $exception) {
       // dd($exception);
     
            return back();
        }

}

public function blogPage(){
   try{
        $blogs = Blog::where('status', 1)->orderby('created_at', 'desc')->paginate(12);
        $blogs_comment = BlogComment::where('status', 1)->orderby('created_at', 'desc')->limit(10);
        $recents = Blog::where('status', 1)->orderby('created_at', 'desc')->paginate(10);
       $CountComments = BlogComment::where('status', 1)->count();
       return view('frontend.pages.blog', compact('blogs', 'recents', 'CountComments', 'blogs_comment'));
   } catch(Exception $exception) {
        //dd($exception);
            return back();
        }
}

public function blogDetailPage($id = null){
    try {
        $blog = Blog::where('slug', $id)->where('status', 1)->first();
        $recents = Blog::where('status', 1)->where('slug', '!=', $id)->orderby('created_at', 'desc')->paginate(5);
        $BlogComments = BlogComment::where('blog_id', $blog->id)->where('status', 1)->paginate(10);
        $CountComments = BlogComment::where('blog_id', $blog->id)->where('status', 1)->count();
        // dd($CountComments);
       return view('frontend.pages.blog-detail', compact('blog', 'recents', 'BlogComments', 'CountComments'));
    } catch(Exception $exception) {
        //dd($exception);
            return back();
        }
}

public function commentSave(Request $request){
    try{
        $inputs = $request->all();
        $validator = (new Blog)->front_validate($inputs);
        if( $validator->fails() ) {
          return back()->withErrors($validator)->withInput();
        } 
    $BlogComment = new BlogComment();
    $BlogComment->name = $request->name;
    $BlogComment->email = $request->email;
    $BlogComment->comment = $request->comment;
    $BlogComment->blog_id = $request->blog_id;
    $BlogComment->status = 0;
    $BlogComment->save();
    return back()->with('comment_sub', lang('messages.created', lang('comment_sub')));
    } catch(Exception $exception) {
        //dd($exception);
            return back();
    }
}

public function contact(){
   try{
       
    $contact = ContentManagement::where('id', 1)->select('contact')->first();

    return view('frontend.pages.contact', compact('contact'));

   } catch(Exception $exception) {
        //dd($exception);
     
            return back();
    }

}

public function contactEnquiry(Request $request){
    try{
        $inputs = $request->all();
        $validator = (new Contact)->front_contact($inputs);
        if( $validator->fails() ) {
          return back()->withErrors($validator)->withInput();
        } 
 
        (new Contact)->store($inputs);
        $email = $inputs['email'];
        $data['mail_data'] = $inputs;
         
        \Mail::send('email.enquiry', $data, function($message) use ($email){
            $message->from($email);
            $message->to('navjot@shailersolutions.com');
            $message->subject('Enquiry');
        });

        return back()->with('enquiry_sub', lang('messages.created', lang('comment_sub')));

    }catch(Exception $exception) {
       // dd($exception);
     
            return back();
    }
}


public function searchProduct(Request $request) {
      try{

      if($request->q){
      if($request->category_id == 0){
        $products = Product::where('status', 1)->where('name', 'LIKE', '%' . $request->q . '%')->Orwhere('sku', 'LIKE', '%' . $request->q . '%')->select('name', 'url', 'thumbnail', 'regular_price', 'offer_price')->orderby('id', 'DESC')->paginate(28);
        $counts = Product::where('status', 1)->where('name', 'LIKE', '%' . $request->q . '%')->Orwhere('sku', 'LIKE', '%' . $request->q . '%')->count();
      } else {
        $products = Product::where('status', 1)->where('category_id', $request->category_id)->where('name', 'LIKE', '%' . $request->q . '%')->Orwhere('sku', 'LIKE', '%' . $request->q . '%')->select('name', 'url', 'thumbnail', 'regular_price', 'offer_price')->orderby('id', 'DESC')->paginate(28);
        $counts = Product::where('status', 1)->where('category_id', $request->category_id)->where('name', 'LIKE', '%' . $request->q . '%')->Orwhere('sku', 'LIKE', '%' . $request->q . '%')->count();
      }

      $search_key = $request->q;
      $Categorys = Category::where('status', 1)->where('parent_id', NULL)->select('name', 'id', 'url')->where('id', '!=', 13)->Orderby('name')->get();
  
        return view('frontend.pages.search', compact('counts', 'Categorys', 'search_key', 'products'));
        }
        else{
          return back();
        }
      } catch(\Exception $e){

     //  dd($e);
        return back();
      }
      
    }

 
public function terms_and_conditions(){
    try{
        $terms_and_conditions = ContentManagement::where('id', 1)->select('terms_conditions')->first(); 
       return view('frontend.pages.term-condition', compact('terms_and_conditions'));
    } catch(\Exception $ex){
         
         //dd($ex);
        return back();
    }
 } 

  public function privacy_policy(){
    try {
          $privacy = ContentManagement::where('id', 1)->select('privacy')->first(); 
          return view('frontend.pages.privacy_policy', compact('privacy'));
        }
        catch (\Exception $exception) {
            return back();
        }
  }

  public function AboutUs(){
    try {
          $about = ContentManagement::where('id', 1)->select('about')->first(); 
          return view('frontend.pages.about', compact('about'));
        }
        catch (\Exception $exception) {
            return back();
        }
  }


function action1(Request $request) {
     if($request->ajax()) {
      $output = '';
      $query = $request->get('query');
      $category_id = $request->category_id;

      if($query != '') {

      if($category_id == 0){
       $data =  Product::where('name', 'like', '%'.$query.'%')->Orwhere('sku', 'LIKE', '%' . $request->q . '%')->select('name', 'url', 'thumbnail')
        ->where('name', 'like', '%'.$query.'%')
        ->orderBy('products.id', 'desc')
        ->get();
      } else {
        $data =  Product::where('name', 'like', '%'.$query.'%')->Orwhere('sku', 'LIKE', '%' . $request->q . '%')->select('name', 'url', 'thumbnail')
        ->where('name', 'like', '%'.$query.'%')->where('category_id', $category_id)
        ->orderBy('products.id', 'desc')
        ->get();
      }

      }
      foreach($data as $row){
        $output .= '
        <li><a href="'.route('productDetail', $row->url).'"><img style="width:50px;margin-right: 6px;" src="'.asset($row->thumbnail).'">
            '.$row->name.'</a>
        </li>
        ';
       }
      $data = array(
       'table_data'  => $output,
      );
      echo json_encode($data);
     }
    }

}