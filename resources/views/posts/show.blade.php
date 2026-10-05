<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;500;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Readex Pro', sans-serif; } </style>
</head>
<body class="bg-[#0b0f19] text-slate-100 min-h-screen py-10">
    <div class="max-w-3xl mx-auto px-4">
        
        <!-- الهيدر الأعلى -->
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('posts.index') }}" class="text-xs text-slate-400 hover:text-white transition">
                ← العودة للرئيسية
            </a>
            
            @auth
                @if(isset($post->user_id) && (string)$post->user_id === (string)auth()->id())
                    <div class="flex gap-2">
                        <a href="{{ route('posts.edit', $post->id) }}" class="bg-amber-600/20 hover:bg-amber-600 text-amber-300 hover:text-white border border-amber-600/40 text-xs font-semibold px-4 py-2 rounded-xl transition">
                            ✏ تعديل المقال
                        </a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-rose-600/20 hover:bg-rose-600 text-rose-300 hover:text-white border border-rose-600/40 text-xs font-semibold px-4 py-2 rounded-xl transition">
                                🗑️ حذف
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-xl text-xs">
                {{ session('success') }}
            </div>
        @endif

        <!-- تفاصيل المقال -->
        <article class="bg-slate-900/80 border border-slate-800 rounded-3xl overflow-hidden mb-8 shadow-2xl backdrop-blur-md">
            @if(!empty($post->image_url))
                <div class="h-72 w-full overflow-hidden">
                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="p-8">
                @if(!empty($post->tags))
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach($post->tags as $tag)
                            <span class="bg-indigo-500/10 text-indigo-300 border border-indigo-500/20 text-xs px-3 py-1 rounded-full">
                                #{{ $tag }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <h1 class="text-3xl font-bold text-white mb-4 leading-tight">{{ $post->title }}</h1>
                
                <div class="text-xs text-slate-400 mb-6 pb-4 border-b border-slate-800 flex justify-between items-center">
                    <span>✍️ الكاتب: <strong class="text-indigo-400">{{ $post->author_name ?? 'زائر' }}</strong></span>
                    <span>👁️ المشاهدات: {{ $post->views_count }}</span>
                </div>

                <div class="text-slate-300 leading-relaxed whitespace-pre-line text-base">
                    {{ $post->content }}
                </div>
            </div>
        </article>

        <!-- زر التعليقات -->
        <div class="mb-6">
            <button onclick="toggleComments()" class="w-full bg-slate-900 hover:bg-slate-800 border border-slate-800 text-indigo-400 font-bold py-3.5 px-6 rounded-2xl flex justify-between items-center transition shadow-lg">
                <span class="flex items-center gap-2 text-sm">
                    💬 التعليقات <span class="bg-indigo-950 text-indigo-300 text-xs px-2.5 py-0.5 rounded-full border border-indigo-800/50">{{ count($post->comments ?? []) }}</span>
                </span>
                <span id="arrowIcon" class="text-xs text-slate-400">▼ اضغط للاستعراض والتفريغ</span>
            </button>
        </div>

        <!-- قسم التعليقات -->
        <section id="commentsSection" class="hidden bg-slate-900/60 border border-slate-800 rounded-3xl p-6 shadow-xl mb-12">
            <div class="space-y-4 mb-8">
                @forelse($post->comments ?? [] as $comment)
                    <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold text-indigo-400 text-xs">{{ $comment['user_name'] }}</span>
                            <span class="text-[10px] text-slate-500">{{ $comment['created_at'] }}</span>
                        </div>
                        <p class="text-slate-300 text-xs leading-relaxed">{{ $comment['comment'] }}</p>
                    </div>
                @empty
                    <p class="text-slate-500 text-xs text-center py-4">لا توجد تعليقات بعد.</p>
                @endforelse
            </div>

            @auth
                <form action="{{ route('posts.comments.store', $post->id) }}" method="POST" class="space-y-4 pt-4 border-t border-slate-800">
                    @csrf
                    <div>
                        <textarea name="comment" rows="3" placeholder="اكتب تعليقك هنا..." required class="w-full bg-slate-950 border border-slate-800 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-indigo-500 transition"></textarea>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs px-6 py-2.5 rounded-xl transition shadow-lg shadow-indigo-600/30">
                        إضافة التعليق
                    </button>
                </form>
            @else
                <div class="p-4 bg-slate-950 rounded-xl border border-slate-800 text-center">
                    <p class="text-slate-400 text-xs mb-2">أنت تتصفح كزائر، يمكن قراءة التعليقات فقط.</p>
                    <a href="{{ route('login') }}" class="text-indigo-400 font-bold underline text-xs">تسجيل الدخول لإضافة تعليق</a>
                </div>
            @endauth
        </section>

    </div>

    <script>
        function toggleComments() {
            const section = document.getElementById('commentsSection');
            const arrow = document.getElementById('arrowIcon');
            if (section.classList.contains('hidden')) {
                section.classList.remove('hidden');
                arrow.innerText = '▲ إغلاق التعليقات';
            } else {
                section.classList.add('hidden');
                arrow.innerText = '▼ اضغط للاستعراض والتفريغ';
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            if (window.location.hash === '#commentsSection') {
                toggleComments();
            }
        });
    </script>
</body>
</html>