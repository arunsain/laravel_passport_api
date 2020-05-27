<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User_table; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Facades\Mail; 
use App\Mail\UserRegisterMail;


class UserController extends Controller 
{


    public $successStatus = 200;
    public $badRequest = 400;

   
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
                //dd($user->tokens);
           // $usrTokens = $user->tokens;
                //foreach($usrTokens as $token){
    	       //echo $token->id;
                //$token->revoke();   
               // }
            $data['token'] =  $user->createToken('MyApp')->accessToken; 
            $data['detail'] = $user;
            return response()->json(['message'=> 'login successfully','data' => $data,'status' => $this->successStatus ], $this->successStatus); 
        }else{ 
            return response()->json(['status' => $this->badRequest,'message'=>'Unauthorised User'],$this->badRequest); 
        } 
    }


    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email|unique:user_tables', 
            'password' => 'required', 
            'device_token' => 'required',
            'device_type' => 'required',
        ]);
            
        if ($validator->fails()) { 
            return response()->json(['status' => $this->badRequest,'message'=>$validator->errors()],$this->badRequest);            
        }
        $otp = mt_rand(100000, 999999);
        $user = User_table::create([

            'full_name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'otp_code' => $otp,
            'device_type' => $request->device_type,
            'device_token' => $request->device_token,
            'is_status' => 0,
        ]); 

        $maildata = $user;
        $maildata->randomCode = $otp;

        Mail::to($user->email)->send(new UserRegisterMail($maildata)); //for email sending
        $data['token'] =  $user->createToken('MyApp')->accessToken; 
        $data['detail'] =  $user;
        return response()->json(['status' => $this->successStatus,'message'=> 'user Register Successfully','data'=>$data], $this->successStatus); 
    }


    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['status'=>$this->successStatus ,'message' =>"fetch detail successfully",'data'=> $user], $this->successStatus); 
    } 


    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
         return response()->json(['status'=>$this->successStatus,'message' => 'logged out Successfully'], $this->successStatus); 
    }


    public function activateUser(Request $request) 
    { 
        $user = Auth::user(); 
        $update =User_table::find($user->id);
        if($request->otp == $update->otp_code ){

            $update->is_status = 1;
            $update->save();

            return response()->json(['status'=>$this->successStatus ,'message' =>"Login successfully",'data'=> $user], $this->successStatus);

        }
        return response()->json(['status'=>$this->badRequest ,'message' =>"otp not matched"], $this->badRequest);  
    } 





}