<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'tags' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        // معالجة الوسوم وفصل كل كلمة إلى وسم مستقل
        $tagsArray = [];
        if ($request->tags) {
            $rawTags = preg_split('/[\s,]+/', $request->tags);
            $tagsArray = array_values(array_filter(array_map('trim', $rawTags)));
        }

        // صورة افتراضية عصرية من Unsplash في حال لم يُحدد المستخدم رابطاً
        $defaultImage = 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1000&auto=format&fit=crop';

        Post::create([
            'user_id' => (string) Auth::id(),
            'author_name' => Auth::user()->name,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'content' => $request->content,
            'tags' => $tagsArray,
            'image_url' => $request->image_url ?: $defaultImage,
            'views_count' => 0,
            'comments' => [],
        ]);

        return redirect()->route('posts.index')->with('success', 'تم نشر المقال بنجاح! ✨');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post->increment('views_count');
        return view('posts.show', compact('post'));
    }

    public function addComment(Request $request, $id)
    {
        if (!Auth::check()) {
            return back()->with('error', 'يجب تسجيل الدخول لإضافة تعليق.');
        }

        $request->validate(['comment' => 'required|string']);

        $post = Post::findOrFail($id);
        $comments = $post->comments ?? [];
        $comments[] = [
            'user_id' => (string) Auth::id(),
            'user_name' => Auth::user()->name,
            'comment' => $request->comment,
            'created_at' => now()->format('Y-m-d H:i'),
        ];

        $post->comments = $comments;
        $post->save();

        return back()->with('success', 'تم إضافة التعليق بنجاح!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if (!Auth::check() || (string)$post->user_id !== (string)Auth::id()) {
            abort(403, 'غير مسموح لك بتعديل هذا المقال.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (!Auth::check() || (string)$post->user_id !== (string)Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'tags' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $tagsArray = [];
        if ($request->tags) {
            $rawTags = preg_split('/[\s,]+/', $request->tags);
            $tagsArray = array_values(array_filter(array_map('trim', $rawTags)));
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'tags' => $tagsArray,
            'image_url' => $request->image_url ?: $post->image_url,
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', 'تم تعديل المقال بنجاح!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (!Auth::check() || (string)$post->user_id !== (string)Auth::id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'تم حذف المقال بنجاح!');
    }
}