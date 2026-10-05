<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب جديد</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center">
    <div class="bg-slate-800 p-8 rounded-2xl border border-slate-700 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-indigo-400">حساب جديد</h2>

        @if($errors->any())
            <div class="mb-4 p-3 bg-rose-500/10 border border-rose-500/30 text-rose-400 text-sm rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm mb-1">الاسم الكامل</label>
                <input type="text" name="name" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm mb-1">البريد الإلكتروني</label>
                <input type="email" name="email" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm mb-1">كلمة المرور</label>
                <input type="password" name="password" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm mb-1">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:outline-none focus:border-indigo-500">
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 font-bold py-3 rounded-xl transition">تسجيل الحساب</button>
        </form>
        <p class="text-xs text-slate-400 mt-4 text-center">لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="text-indigo-400 underline">تسجيل الدخول</a></p>
    </div>
</body>
</html>