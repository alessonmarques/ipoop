<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\GeoHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // checa se aceitou os termos
        if (!$request->input('terms')) {
            return back()->withErrors([
                'terms' => 'Você deve aceitar os termos de uso.',
            ]);
        }

       // se o reCAPTCHA for inválido, o Laravel irá automaticamente retornar um erro de validação
       $request->validate([
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'Por favor, marque o reCAPTCHA.',
        ]);

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!($response->json()['success'] ?? false)) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Falha ao validar o reCAPTCHA, tente novamente.',
            ]);
        }

        // se o reCAPTCHA for validado, continue com a validação do usuário
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $ip = $request->ip();
        $geo = GeoHelper::getLocationFromIP($ip);

        // obtemos a localização do IP
        $sessionData = [
            'ip' => $ip,
            'user_agent' => $request->userAgent(),
            'registered_at' => now()->toIso8601String(),
            'locale' => $request->getPreferredLanguage(),
            'timezone' => date_default_timezone_get(),
        ];
        if (isset($geo['reason'])) {
            $sessionData['location'] = [
                'error' => $geo['reason'],
            ];
        } else {
            $sessionData['location'] = [
                'city' => $geo['city'] ?? null,
                'region' => $geo['region'] ?? null,
                'country' => $geo['country_name'] ?? null,
                'latitude' => $geo['latitude'] ?? null,
                'longitude' => $geo['longitude'] ?? null,
                'asn' => $geo['asn'] ?? null,
            ];
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'registered_session_data' => json_encode($sessionData),
        ];
        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
