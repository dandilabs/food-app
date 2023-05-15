<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\PasswordValidationRules;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    use PasswordValidationRules;

    public function login(Request $request)
    {
        try {
            //Validasi Input
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);

            //Mengecek login nya
            $credentials = request(['email','password']);
            if(!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);

                //Jikas hash tidak sesuai maka beri error
                $user = User::where('email', $request->email)->first();
                if(!Hash::check($request->password, $user->password, [])) {
                    throw new \Exception('Invalid Credentials');
                }

                //jika berhasil maka akan login

                $tokenResult = $user->createToken('authToken')->plainTextToken;
                return ResponseFormatter::success([
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'user' => $user
                ], 'Authenticated');
            }
        } catch(Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authenticated Failed', 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name'      => ['required','string','max:255'],
                'email'     => ['required','string','email','max:255','unique:users'],
                'password'  => $this->passwordRules()
            ]);

            User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'address'       => $request->address,
                'houseNumber'   => $request->houseNumber,
                'phoneNumber'   => $request->phoneNumber,
                'city'          => $request->city,
                'password'      => Hash::make($request->password),
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token'  => $tokenResult,
                'token_type'    => 'Bearer',
                'user'          => $user
            ]);

        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message'   => 'Something went wrong',
                'error'     => $error
            ],'Authentication Failed', 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token,'Token Revoked');
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success(
            $request->user(),'Data profile user berhasil diambil'
        );
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $user->update($data);

        return ResponseFormatter::success($user, 'Profile updated');
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file'  => 'required|image|max:2048'
        ]);

        if($validator->fails())
        {
            return ResponseFormatter::error([
                'error' => $validator->errors()
                ], 'Update Photo Fails', 401
            );
        }

        if($request->file('file'))
        {
            $file = $request->file->store('assets/user','public');

            //simpan foto ke database
            $user = Auth::user();
            $user->profile_photo_path = $file;
            $user->update();

            return ResponseFormatter::success([$file], 'File successfully uploaded');
        }
    }

    
}
