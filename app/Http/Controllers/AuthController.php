<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            // validate the incoming request
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // check to see if the user is authorized or not
            if (!Auth::attempt(request(['email', 'password'])))
                throw new UnauthorizedException('Sorry, Authorization Failed');

            // get the user from the email address provided
            $user = User::whereEmail($request->email)->first();

            // throw model not found error if unable to find the user
            if (!$user || $user->count() == 0)
                throw new ModelNotFoundException('Unable to find the user');

            // check to see if the entered password is correct or not
            if (!Hash::check($request->password, $user->password, []))
                throw ValidationException::withMessages([
                    'message' => 'Sorry, The password did not match'
                ]);

            // create a token for the user
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => 200,
                'token_type' => 'Bearer',
                'access_token' => $tokenResult,
                'bearer_token' => 'Bearer ' . $tokenResult
            ], 200);

        } catch (ValidationException $exception) {

            return $this->errorResponse($exception->getMessage(), 422);

        } catch (UnauthorizedException $exception) {

            return $this->errorResponse($exception->getMessage(), 403);

        } catch (ModelNotFoundException $exception) {

            return $this->errorResponse($exception->getMessage(), 404);

        } catch (\Exception $error) {

            return $this->errorResponse($error->getMessage(), 500);

        }
    }
}
