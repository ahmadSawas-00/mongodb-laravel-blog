<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المقال</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen font-sans">
    <div class="max-w-2xl mx-auto px-4 py-10">
        <a href="{{ route('posts.show', $post->id) }}" class="text-slate-400 hover:text-white text-sm mb-6 inline-block">← إلغاء والعودة للمقال</a>
        
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8 shadow-xl">
            <h1 class="text-2xl font-bold mb-6 text-amber-400">✏️ تعديل المقال</h1>

            <form action="{{ route('posts.update', $post->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">عنوان المقال</label>
                    <input type="text" name="title" value="{{ $post->title }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">الوسوم</label>
                    <input type="text" name="tags" value="{{ implode(', ', $post->tags ?? []) }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">محتوى المقال</label>
                    <textarea name="content" rows="6" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-amber-500">{{ $post->content }}</textarea>
                </div>

                <button type="submit" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-bold py-3 rounded-xl transition">
                    حفظ التعديلات 💾
                </button>
            </form>
        </div>
    </div>
</body>
</html>