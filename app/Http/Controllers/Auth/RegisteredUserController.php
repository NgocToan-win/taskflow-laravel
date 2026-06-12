<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
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
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'name.required' => 'Họ và tên bắt buộc phải nhập.',
            'name.string' => 'Họ và tên phải là chuỗi chữ.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'name.regex' => 'Họ và tên phải là chuỗi chữ (chỉ bao gồm chữ cái và khoảng trắng).',
            'email.required' => 'Email bắt buộc phải nhập.',
            'email.email' => 'Email phải đúng định dạng thư điện tử (email@example.com).',
            'email.unique' => 'Email đã tồn tại trong database (không được đăng ký trùng email đã có trong database).',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'password.required' => 'Mật khẩu bắt buộc phải nhập.',
            'password.min' => 'Mật khẩu phải tối thiểu 8 ký tự.',
            'password.confirmed' => 'Mật khẩu phải khớp hoàn toàn với ô "Xác nhận mật khẩu".',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
