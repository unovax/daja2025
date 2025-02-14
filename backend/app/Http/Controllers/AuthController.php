<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseManager;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetToken;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $tenant = Tenant::create([
                'code' => $request->tenant['code'],
                'name' => $request->tenant['name'],
            ]);

            $user = $tenant->users()->create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            Auth::login($user);
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            DB::commit();
            return ResponseManager::success('Registro del usuario exitoso', [
                'user' => $user->load('tenant'),
                'token' => $token
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return ResponseManager::error($th->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (!Auth::attempt($credentials)) {
                return ResponseManager::error('Credenciales inválidas', 401);
            }

            $user = Auth::user();

            // Generar el token
            $token = $user->createToken('auth_token')->plainTextToken;

            return ResponseManager::success('Inicio de sesión exitoso', [
                'user' => $user->load('tenant'),
                'token' => $token
            ]);
        } catch (\Throwable $th) {
            return ResponseManager::error($th->getMessage());
        }

    }

    public function logout()
    {
        try {
            // Obtener el usuario autenticado
            $user = Auth::guard('sanctum')->user();

            if (!$user) {
                return ResponseManager::error('No hay ningún usuario autenticado', 401);
            }

            // Revocar el token actual del usuario
            $user->currentAccessToken()->delete();

            return ResponseManager::success('Cierre de sesión exitoso');
        } catch (\Throwable $th) {
            return ResponseManager::error($th->getMessage());
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            $token = Str::random(32);

            PasswordResetToken::where('email', $user->email)->delete();
            PasswordResetToken::create([
                'email' => $user->email,
                'token' => Hash::make($token)
            ]);
            Mail::to($user)->send(new ResetPasswordMail($user, $token));
            return ResponseManager::success('Correo enviado correctamente.');
        } catch (\Throwable $th) {
            return ResponseManager::error($th->getMessage());
        }

    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return ResponseManager::error('Usuario no encontrado.', 404);
            }

            $token = PasswordResetToken::where('email', $request->email)->first();
            if (!$token) {
                return ResponseManager::error('El token de recuperación no existe o ya ha sido utilizado.', 422);
            }

            if (!Hash::check($request->token, $token->token)) {
                return ResponseManager::error('El token de recuperación no es válido, realice el proceso nuevamente.', 422);
            }

            if ($token->created_at < Carbon::now()->subMinutes(30)) {
                return ResponseManager::error('El token de recuperación ya expiró, realice el proceso nuevamente.', 422);
            }

            // Actualizar contraseña
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            // Eliminar token
            $token->delete();

            return ResponseManager::success('Contraseña restablecida correctamente.');

        } catch (\Throwable $th) {
            return ResponseManager::error($th->getMessage(), 500);
        }
    }


}
