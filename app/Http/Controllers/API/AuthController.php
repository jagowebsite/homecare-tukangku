<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle a login request to the api.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                200
            );
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Email or password is incorrect.',
                    'data' => null,
                ],
                200
            );
        }
        // if ($user->getRoleNames()[0] != 'admin_office') {
        //     return response()->json(
        //         [
        //             'status' => 'failed',
        //             'message' => 'You have no access token',
        //             'data' => null,
        //         ],
        //         200
        //     );
        // }
        if (!$user->hasVerifiedEmail()) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' =>
                        'Please check your email to verify your account',
                    'data' => [
                        'token' => '',
                        'role' => $user->getRoleNames()[0],
                        'verified' => false,
                    ],
                ],
                200
            );
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Login success.',
                'data' => [
                    'token' => $user->createToken($request->device_name)
                        ->plainTextToken,
                    'role' => $user->getRoleNames()[0],
                    'verified' => true,
                ],
            ],
            200
        );
    }

    /**
     * Handle a request verification email for user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyEmail(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                200
            );
        }
        $user = User::where('email', $request->email)->first();
        if (!$user->hasVerifiedEmail()) {
            $key = 'send-email.' . $user->id;
            $max = 1;
            $decay = 300;

            if (RateLimiter::tooManyAttempts($key, $max)) {
                $seconds = RateLimiter::availableIn($key);
                return response()->json(
                    [
                        'status' => 'failed',
                        'message' =>
                            'You have made a verification request, please check your email again on the spam, promotions, or primary. You can try again in ' .
                            $seconds .
                            ' seconds',
                        'data' => null,
                    ],
                    200
                );
            } else {
                RateLimiter::hit($key, $decay);
                $user->sendEmailVerificationNotification();
                return response()->json(
                    [
                        'status' => 'success',
                        'message' =>
                            'Email verification has been sended, Please check your email to verify your account',
                        'data' => null,
                    ],
                    200
                );
            }
        }
    }
    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                200
            );
        }
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
            ? response()->json(
                [
                    'status' => 'success',
                    'message' =>
                        'Reset password has been sended at your email, please check your email',
                ],
                200
            )
            : response()->json(
                [
                    'status' => 'failed',
                    'message' =>
                        'You have requested password reset recently, please check your email.',
                ],
                200
            );
    }

    /**
     * handle change password user for api.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => 'required',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                200
            );
        }
        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Current password does not match!',
                ],
                200
            );
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Your password has been changed.',
            ],
            200
        );
    }
    /**
     * handle register user to apps
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {   DB::beginTransaction();
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                // 'password_confirmation' => 'required',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                200
            );
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $user->assignRole('user');
        // $user->sendEmailVerificationNotification();
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' =>
                    'Register success, please check your email to verified your account.',
            ],
            200
        );
    }
    /**
     * Handle a logout request to the api.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request
            ->user()
            ->currentAccessToken()
            ->delete();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Logout success.',
                'data' => null,
            ],
            200
        );
    }
    /**
     * Display the specified resource of user data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUser(Request $request)
    {
        if ($request->user()) {
            $user_id = @$request->user()->id;
            $user = User::find($user_id);
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Success get data user.',
                    'data' => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name,
                        'date_of_birth' => $user->date_of_birth,
                        'address' => $user->address,
                        'number' => $user->number,
                        'images' => $user->images
                            ? asset('storage/' . $user->images)
                            : url('/') . '/assets/icon/user_default.png',
                        'ktp_image' => $user->ktp_image
                            ? asset('storage/' . $user->ktp_image)
                            : '',
                        'role' => [
                            'name' => @$request->user()->getRoleNames()[0],
                        ]
                    ],
                ],
                200
            );
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized.',
                'data' => null,
            ]);
        }
    }

    /**
     * Handle a logout request to the api.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'address' => 'required',
                'date_of_birth' => 'required',
                'number' => 'required',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
            ]
        );
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                200
            );
        }
        $user_id = @$request->user()->id;
        $user = User::find($user_id);
        $user->name = $request->name;
        $user->address = $request->address;
        $user->date_of_birth = $request->date_of_birth;
        $user->number = $request->number;
        $user->save();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Your profile has been updated.',
            ],
            201
        );
    }

    /**
     * Handle a logout request to the api.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateImage(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'images' => 'image|file|max:8192',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
                'image' =>
                    'File upload must be an image (jpg, jpeg, png, bmp, gif, svg, or webp).',
                'max' =>
                    'Maximum file size to upload is 8MB (8192 KB). If you are uploading a photo, try to reduce its resolution to make it under 8MB',
                'confirmed' => 'The password confirmation does not match',
            ]
        );
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                200
            );
        }
        $user_id = @$request->user()->id;
        $user = User::find($user_id);
        if ($request->file('images')) {
            if ($user->images) {
                Storage::delete(@$user->images);
            }
            $user_image = @$request->file('images')->store('user_image');
            $user->images = $user_image;
        }
        $user->save();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Your profile image has been updated.',
            ],
            201
        );
    }
    /**
     * Handle a logout request to the api.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateKtpImage(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ktp_image' => 'image|file|max:8192',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
                'image' =>
                    'File upload must be an image (jpg, jpeg, png, bmp, gif, svg, or webp).',
                'max' =>
                    'Maximum file size to upload is 8MB (8192 KB). If you are uploading a photo, try to reduce its resolution to make it under 8MB',
                'confirmed' => 'The password confirmation does not match',
            ]
        );
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                200
            );
        }
        $user_id = @$request->user()->id;
        $user = User::find($user_id);
        if ($request->file('ktp_image')) {
            if ($user->ktp_image) {
                Storage::delete(@$user->ktp_image);
            }
            $user_ktp = @$request->file('ktp_image')->store('user_image');
            $user->ktp_image = $user_ktp;
        }
        $user->save();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Your ktp image has been updated.',
            ],
            201
        );
    }
}
