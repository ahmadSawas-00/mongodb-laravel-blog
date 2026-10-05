<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مقال جديد</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;500;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Readex Pro', sans-serif; } </style>
</head>
<body class="bg-[#0b0f19] text-slate-100 min-h-screen py-10">
    <div class="max-w-2xl mx-auto px-4">
        <a href="{{ route('posts.index') }}" class="text-xs text-slate-400 hover:text-white mb-6 inline-block">← العودة للرئيسية</a>

        <div class="bg-slate-900/80 border border-slate-800 p-8 rounded-3xl shadow-2xl backdrop-blur-md">
            <h1 class="text-2xl font-bold text-white mb-6">✍️ كتابة مقال جديد</h1>

            <form action="{{ route('posts.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">عنوان المقال</label>
                    <input type="text" name="title" required placeholder="أدخل عنواناً جذاباً..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">رابط صورة الغلاف (اختياري)</label>
                    <input type="url" name="image_url" placeholder="https://images.unsplash.com/..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-indigo-500 transition">
                    <p class="text-[11px] text-slate-500 mt-1">ضع رابط صورة من جوجل أو Unsplash، وإذا تركته فارغاً سيتم اختيار صورة عصرية تلقائياً.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">الوسوم (Tags)</label>
                    <input type="text" name="tags" placeholder="تواصل, افكار, مجتمعية" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-indigo-500 transition">
                    <p class="text-[11px] text-slate-500 mt-1">افصل بين الكلمات بفاصلة `,` أو مسافة وسيتم تفكيكها لوسوم منفصلة.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">محتوى المقال</label>
                    <textarea name="content" rows="7" required placeholder="اكتب تفاصيل مقالك..." class="w-full bg-slate-950 border border-slate-800 rounded-xl p-4 text-xs text-white focus:outline-none focus:border-indigo-500 transition"></textarea>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-indigo-500/25 text-xs">
                    🚀 نشر المقال
                </button>
            </form>
        </div>
    </div>
</body>
</html>