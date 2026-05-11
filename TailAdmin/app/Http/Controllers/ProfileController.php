<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }
    
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'sexo' => 'required|in:M,F',
            'cargo' => 'required|string|max:255',
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|min:6|confirmed',
        ]);
        
        $user->nome = $validated['nome'];
        $user->email = $validated['email'];
        $user->sexo = $validated['sexo'];
        $user->cargo = $validated['cargo'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();
        
        return redirect()->route('profile.show')
                        ->with('success', 'Perfil atualizado com sucesso!');
    }
    
    public function destroy()
    {
        $user = Auth::user();
        
        // Optional: Add any cleanup logic here
        
        Auth::logout();
        $user->delete();
        
        return redirect()->route('home')
                        ->with('success', 'Sua conta foi deletada com sucesso.');
    }
}