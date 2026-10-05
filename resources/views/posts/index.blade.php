<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المدونة الاحترافية - Ahmad Sawas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Readex Pro', sans-serif; } </style>
</head>
<body class="bg-[#0b0f19] text-slate-100 min-h-screen flex flex-col justify-between selection:bg-indigo-500 selection:text-white">

    <!-- خلفية نيون جاذبة -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute top-1/2 -left-40 w-96 h-96 bg-purple-600/20 rounded-full blur-[120px]"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-8 w-full">
        
        <!-- الهيدر الرئيسي -->
        <header class="flex flex-col sm:flex-row justify-between items-center pb-8 border-b border-slate-800/80 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                    🚀 مدونة المونغو العصرية
                </h1>
                <p class="text-slate-400 text-xs mt-1">طُوّرت بكل شَغَف بواسطة <span class="text-indigo-400 font-semibold">Ahmad Sawas</span> • Laravel & MongoDB</p>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-slate-300">أهلاً، <strong class="text-indigo-400 font-bold">{{ auth()->user()->name }}</strong></span>
                        
                        <a href="{{ route('posts.create') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold text-xs px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-indigo-500/25 flex items-center gap-1.5 hover:scale-105">
                            <span>+</span> مقال جديد
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-rose-500/10 text-rose-400 border border-rose-500/20 text-xs font-semibold px-3.5 py-2.5 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                خروج
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-xs text-slate-300 hover:text-white px-3 py-2">تسجيل الدخول</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-lg shadow-indigo-500/20">
                            إنشاء حساب
                        </a>
                    </div>
                @endauth
            </div>
        </header>

        <!-- شريط الإحصائيات السريع -->
        <div class="my-8 p-6 bg-slate-900/40 border border-slate-800 rounded-3xl backdrop-blur-md flex flex-wrap justify-around items-center gap-4 text-center">
            <div>
                <span class="text-2xl font-extrabold text-indigo-400 block">{{ count($posts) }}</span>
                <span class="text-xs text-slate-400">إجمالي المقالات المنشورة</span>
            </div>
            <div class="h-8 w-px bg-slate-800 hidden sm:block"></div>
            <div>
                <span class="text-2xl font-extrabold text-purple-400 block">⚡ MongoDB</span>
                <span class="text-xs text-slate-400">سرعة استجابة فائقة</span>
            </div>
            <div class="h-8 w-px bg-slate-800 hidden sm:block"></div>
            <div>
                <span class="text-2xl font-extrabold text-pink-400 block">Laravel 13</span>
                <span class="text-xs text-slate-400">بيئة عمل قوية وآمنة</span>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-sm flex items-center gap-2">
                ✨ {{ session('success') }}
            </div>
        @endif

        <!-- شبكة المقالات بأسلوب الكروت الحديثة -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
                @php
                    $wordCount = str_word_count(strip_tags($post->content));
                    $readTime = ceil($wordCount / 100) ?: 1;
                @endphp

                <article class="group bg-slate-900/60 backdrop-blur-md border border-slate-800 rounded-3xl overflow-hidden hover:border-indigo-500/40 transition-all duration-300 flex flex-col justify-between hover:-translate-y-1.5 shadow-xl hover:shadow-2xl hover:shadow-indigo-500/10">
                    <div>
                        <div class="relative h-48 w-full overflow-hidden bg-slate-800">
                            <img src="{{ $post->image_url ?? 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1000' }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0b0f19] via-transparent to-transparent"></div>
                            
                            <div class="absolute top-3 right-3 left-3 flex justify-between items-center text-[11px] font-medium">
                                <span class="bg-slate-950/70 backdrop-blur-md border border-slate-700/50 text-slate-200 px-3 py-1 rounded-full">
                                    ✍️ {{ $post->author_name ?? 'زائر' }}
                                </span>
                                <span class="bg-slate-950/70 backdrop-blur-md border border-slate-700/50 text-indigo-300 px-2.5 py-1 rounded-full">
                                    ⏱️ {{ $readTime }} دقيقة قراءة
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                @foreach($post->tags ?? [] as $tag)
                                    <span class="bg-indigo-500/10 text-indigo-300 border border-indigo-500/20 text-[10px] px-2.5 py-0.5 rounded-md font-medium">
                                        #{{ $tag }}
                                    </span>
                                @endforeach
                            </div>

                            <h2 class="text-lg font-bold text-white group-hover:text-indigo-400 transition-colors mb-2 line-clamp-2 leading-snug">
                                <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                            </h2>

                            <p class="text-slate-400 text-xs leading-relaxed line-clamp-3 mb-4">
                                {{ Str::limit(strip_tags($post->content), 120) }}
                            </p>
                        </div>
                    </div>

                    <div class="px-6 pb-6 pt-3 border-t border-slate-800/60 flex justify-between items-center text-xs text-slate-400">
                        <div class="flex items-center gap-3 text-[11px]">
                            <span>👁️ {{ $post->views_count }}</span>
                            <a href="{{ route('posts.show', $post->id) }}#commentsSection" class="hover:text-indigo-400 transition flex items-center gap-1">
                                💬 {{ count($post->comments ?? []) }}
                            </a>
                        </div>

                        <a href="{{ route('posts.show', $post->id) }}" class="text-indigo-400 font-semibold text-xs hover:text-indigo-300 flex items-center gap-1">
                            اقرأ المزيد ←
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-20 bg-slate-900/40 border border-dashed border-slate-800 rounded-3xl">
                    <p class="text-slate-400 text-sm mb-3">لا توجد مقالات نشرت بعد.</p>
                </div>
            @endforelse
        </div>

    </div>

    <!-- الفوتر مع الكوبي رايت والحفظ الخاص بك -->
    <footer class="mt-20 border-t border-slate-800/80 bg-slate-950/60 backdrop-blur-md py-8">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-400">
            <div>
                © {{ date('Y') }} جميع الحقوق محفوظة لـ <strong class="text-indigo-400 font-bold">Ahmad Sawas</strong>.
            </div>
            <div class="flex items-center gap-6">
                <a href="https://github.com/ahmadSawas-00" target="_blank" class="hover:text-white transition">GitHub Profile</a>
                <span>•</span>
                <span class="text-slate-500">مُطور بـ ❤️ باستخدام Laravel & MongoDB</span>
            </div>
        </div>
    </footer>

</body>
</html>