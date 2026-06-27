<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
                if (!$user->email_verified_at) {
                    $user->update(['email_verified_at' => now()]);
                }

                Log::info('User login via Google', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                ]);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => null,
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]);

                Log::info('User baru dibuat via Google', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                ]);
            }

            Auth::login($user);

            return redirect()->intended('/dashboard');

        } catch (InvalidStateException $e) {
            Log::error('Google login InvalidStateException', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('login')
                ->withErrors(['email' => 'Login Google gagal, silakan coba lagi.']);

        } catch (\Exception $e) {
            Log::error('Google login gagal', [
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}