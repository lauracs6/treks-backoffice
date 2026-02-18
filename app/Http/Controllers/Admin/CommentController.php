<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Trek;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    // Listado de comentarios con filtros por estado
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        $trekId = $request->query('trek_id', 'all');
        $score  = $request->query('score', 'all');
        $search = trim((string) $request->query('q'));

        $comments = Comment::query()
            ->with(['user', 'meeting.trek'])
            ->withCount('images')

            // search user name / lastname
            ->when($search !== '', function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%");
                });
            })

            // trek filter
            ->when($trekId !== 'all', function ($query) use ($trekId) {
                $query->whereHas('meeting', function ($q) use ($trekId) {
                    $q->where('trek_id', $trekId);
                });
            })

            // score filter
            ->when($score !== 'all', function ($query) use ($score) {
                $query->where('score', $score);
            })

            // status filter
            ->when($status === 'approved', fn ($q) => $q->where('status', 'y'))
            ->when($status === 'pending', fn ($q) => $q->where('status', '!=', 'y'))

            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $treks = Trek::orderBy('regnumber')->get();

        return view('admin.comments.index', compact(
            'comments',
            'status',
            'trekId',
            'treks',
            'score',
            'search'
        ));
    }


    // Show del comentario
    public function show(Comment $adminComment)
    {
        $comment = $adminComment->load([
            'user.role',
            'meeting.trek',
            'meeting.user',
            'images'
        ]);

        $previous = Comment::where('id', '<', $comment->id)
            ->orderByDesc('id')
            ->first();

        $next = Comment::where('id', '>', $comment->id)
            ->orderBy('id')
            ->first();

        return view('admin.comments.show', compact(
            'comment',
            'previous',
            'next'
        ));
    }


    // Vista de detalle para moderación del comentario
    public function edit(Comment $adminComment)
    {
        $adminComment->load(['user', 'meeting.trek', 'images']);

        return view('admin.comments.edit', [
            'comment' => $adminComment,
        ]);
    }

    // Actualiza el estado del comentario (aprobado/pendiente)
    public function update(Request $request, Comment $adminComment)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['y', 'n'])],
        ]);

        $adminComment->update($data);

        return redirect()
            ->route('admin.comments.edit', $adminComment)
            ->with('status', 'Comentario actualizado.');
    }

    // Da de baja (pone status = 'n')
    public function deactivate(Comment $adminComment)
    {
        $adminComment->update([
            'status' => 'n',
        ]);

        return redirect()
            ->route('admin.comments.index')
            ->with('status', 'Comentario desactivado.');
    }

    // Da de alta (pone status = 'y')
    public function activate(Comment $adminComment)
    {
        $adminComment->update([
            'status' => 'y',
        ]);

        return redirect()
            ->route('admin.comments.index')
            ->with('status', 'Comentario activado.');
    }

}
