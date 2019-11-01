<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 

use Carbon\Carbon;
use Session;
use File;
use Input;
use DB;

use App\User; 
use App\UserDetails;
use Illuminate\Support\Facades\Auth; 

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use GuzzleHttp\Client;
use App\Industry;

use Response;
use Image;
use Storage;

class UserController extends Controller {

public $successStatus = 200;

/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function authenticate(Request $request){
            $credentials = $request->only('email', 'password');
            $token = '';
            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            $currentUser = Auth::user();

            return response()->json(['access_token'=>$token,'message'=>'Authorized','token_type'=>'Bearer','expires_at'=>'','uid'=>$currentUser->id,"user_type"=>$currentUser->user_type]);
    }
/** 
     * logout api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function unauthenticate(Request $request){
    //    return 1;
        // $this->validate($request, [
        //     'token' => 'required'
        // ]);
 
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
 
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
}
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request){

                $validator = Validator::make($request->all(), [
                'user_type' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create([
                'user_type' => $request->get('user_type'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);


            $date = date('m-d-Y_his');

       
            $profile_pic = '';
            $imageNumber = 1;
            $user_folder_path = storage_path().'/user/user_profile/';

            if(!File::exists($user_folder_path))File::makeDirectory($user_folder_path, 0777, true);

            if($request->profile_pic && $request->hasFile('profile_pic')){
//                 return "enter to second if";
                $files = $request->file('profile_pic');
                foreach($files as $file){
                $extension = strtolower($file->getClientOriginalExtension());
                    if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'PNG'){
//                         return "enter to third if";
                        $file_name='';
                        $thumb_file_name='';
                        if($extension == 'jpg' || $extension == 'jpeg'){
                            $file_name = $user->id.'_'.$imageNumber.'_'.$date.'.jpg';
                            $thumb_file_name = $user->id.'_'.$imageNumber.'_'.$date.'_thumb.jpg';
                        }else if($extension == 'png' || $extension == 'PNG'){
                            $file_name = $user->id.'_'.$imageNumber.'_'.$date.'.png';
                            $thumb_file_name = $user->id.'_'.$imageNumber.'_'.$date.'_thumb.png';
                        }
                        $profile_pic=$file_name;
                            $file->move($user_folder_path, $file_name);
                        Image::make($user_folder_path . $file_name)->save($user_folder_path.$thumb_file_name);
                    $imageNumber = $imageNumber +1;
//                         return $profile_pic;
                    if(env('APP_ENV') != 'development'){
                    $disk = Storage::disk('gcs');
                    // return $file;
                    $disk->put('profile_pic/'.$file_name, Image::make($user_folder_path . $file_name)->save($user_folder_path.$thumb_file_name));
                    $disk->setVisibility('profile_pic/'.$file_name, 'public');
                    }
                }else{
                    return response()->json(['success'=>0,'message' =>'profile image type should be a image(jpg,png)'.$extension]);
                    }
                }
            }
            $userDetails = UserDetails::create([
                'user_id' => $user->id, 
                'first_name' => $request->first_name, 
                'last_name' => $request->last_name, 
                'address' => $request->address === null ? "" : $request->address, 
                'nic_or_passport' => $request->nic_or_passport  === null ? "" : $request->nic_or_passport, 
                'contact_number' => $request->contact_number, 
                'profile_pic' => $profile_pic,
                ]);
             
        $access_token = JWTAuth::fromUser($user);
        $message = 'Authorized';
        $token_type= 'Bearer';
        $expires_at = '';

        $uid = $user->id;
        $user_type = $user->user_type;

        return response()->json(compact('access_token','message','token_type','expires_at','uid','user_type'),201);
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getAuthenticatedUser(){
            try {
                if (! $user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
                }
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return response()->json(['token_expired'], 401);
            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return response()->json(['token_invalid'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                return response()->json(['token_absent'], $e->getStatusCode());
            }

            $userType = $user->user_type;
            $userDetails = '';
            $temp = [];

                $userDetails = UserDetails::where('user_id','=',$user->id)->get()->first();

                $temp['id'] = $user->id;
                $temp['user_type'] = $user->user_type;
                $temp['email'] = $user->email;
                $temp['first_name'] = $userDetails->first_name;
                $temp['last_name'] = $userDetails->last_name;
                $temp['nic_or_passport'] = $userDetails->nic_or_passport;
                $temp['address'] = $userDetails->address;
                $temp['contact_number'] = $userDetails->contact_number;
                if(env('APP_ENV') == 'development'){
                $temp['profile_pic'] = '/api/user/get/profile/?pid='.$userDetails->profile_pic;
                }else{
                $disk = Storage::disk('gcs');
                $temp['profile_pic'] =$disk->url('profile_pic/'.$userDetails->profile_pic);
                }
            
            return response()->json(['user'=>$temp]);
    }

    public function get_image(Request $request){

        $path ='';
 
            $record = UserDetails::where('profile_pic','=',$request->pid)->first();
            if(empty($record)) return response()->json(['error'=> 'profile picture not found']);
    
            $path = storage_path().'/user/user_profile/'.$request->pid;
            if(!File::exists($path)) return response()->json(['error'=>'File not Found']);
    

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function check_email(Request $request){
        $isValid = true;
        if(User::where('email', '=', $request->email)->exists()){
            $isValid = false;
        }
        return response()->json(['isValid'=>$isValid]);
    }


    public function update_profile_img(Request $request){

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], 401);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        $date = date('m-d-Y_his');

        $profile_pic = '';
        $imageNumber = 1;
        $user_folder_path = storage_path().'/user/user_profile/';

        if(!File::exists($user_folder_path))File::makeDirectory($user_folder_path, 0777, true);

        if($request->profile_pic && $request->hasFile('profile_pic')){
//                 return "enter to second if";
            $files = $request->file('profile_pic');
            foreach($files as $file){
            $extension = strtolower($file->getClientOriginalExtension());
                if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'PNG'){
//                         return "enter to third if";
                    $file_name='';
                    $thumb_file_name='';
                    if($extension == 'jpg' || $extension == 'jpeg'){
                        $file_name = $user->id.'_'.$imageNumber.'_'.$date.'.jpg';
                        $thumb_file_name = $user->id.'_'.$imageNumber.'_'.$date.'_thumb.jpg';
                    }else if($extension == 'png' || $extension == 'PNG'){
                        $file_name = $user->id.'_'.$imageNumber.'_'.$date.'.png';
                        $thumb_file_name = $user->id.'_'.$imageNumber.'_'.$date.'_thumb.png';
                    }
                    $profile_pic=$file_name;
                        $file->move($user_folder_path, $file_name);
                    Image::make($user_folder_path . $file_name)->save($user_folder_path.$thumb_file_name);
                $imageNumber = $imageNumber +1;
//                         return $profile_pic;
                if(env('APP_ENV') != 'development'){
                $disk = Storage::disk('gcs');
                // return $file;
                $disk->put('profile_pic/'.$file_name, Image::make($user_folder_path . $file_name)->save($user_folder_path.$thumb_file_name));
                $disk->setVisibility('profile_pic/'.$file_name, 'public');
                }
            }else{
                return response()->json(['success'=>0,'message' =>'profile image type should be a image(jpg,png)'.$extension]);
                }
            }
        }

        if(isset($profile_pic) && trim($profile_pic) !== ''){
            $userDetails = UserDetails::where('user_id','=',$user->id)
            ->update(['profile_pic' => $profile_pic]);
        }

            $userType = $user->user_type;
            $userDetails = '';
            $temp = [];

                $userDetails = UserDetails::where('user_id','=',$user->id)->get()->first();

                $temp['id'] = $user->id;
                $temp['user_type'] = $user->user_type;
                $temp['email'] = $user->email;
                $temp['first_name'] = $userDetails->first_name;
                $temp['last_name'] = $userDetails->last_name;
                $temp['nic_or_passport'] = $userDetails->nic_or_passport;
                $temp['address'] = $userDetails->address;
                $temp['contact_number'] = $userDetails->contact_number;
                if(env('APP_ENV') == 'development'){
                $temp['profile_pic'] = '/api/user/get/profile/?pid='.$userDetails->profile_pic;
                }else{
                $disk = Storage::disk('gcs');
                $temp['profile_pic'] =$disk->url('profile_pic/'.$userDetails->profile_pic);
                }
            
            return response()->json(['user'=>$temp]);
    }

    public function update_profile_detailes(Request $request){
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], 401);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        $address = $user->address === null ? "" : $user->address;
        $nic_or_passport = $user->nic_or_passport === null ? "" : $user->nic_or_passport;

        $userDetails = UserDetails::where('user_id','=',$user->id)
            ->update([
                'first_name' => $request->first_name, 
                'last_name' => $request->last_name, 
                'address' => $request->address === null ? $address : $request->address, 
                'nic_or_passport' => $request->nic_or_passport  === null ? $nic_or_passport : $request->nic_or_passport, 
                'contact_number' => $request->contact_number
            ]);

            $userType = $user->user_type;
            $userDetails = '';
            $temp = [];

                $userDetails = UserDetails::where('user_id','=',$user->id)->get()->first();

                $temp['id'] = $user->id;
                $temp['user_type'] = $user->user_type;
                $temp['email'] = $user->email;
                $temp['first_name'] = $userDetails->first_name;
                $temp['last_name'] = $userDetails->last_name;
                $temp['nic_or_passport'] = $userDetails->nic_or_passport;
                $temp['address'] = $userDetails->address;
                $temp['contact_number'] = $userDetails->contact_number;
                if(env('APP_ENV') == 'development'){
                $temp['profile_pic'] = '/api/user/get/profile/?pid='.$userDetails->profile_pic;
                }else{
                $disk = Storage::disk('gcs');
                $temp['profile_pic'] =$disk->url('profile_pic/'.$userDetails->profile_pic);
                }
            
            return response()->json(['user'=>$temp]);
    }

}
