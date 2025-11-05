<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notes = Note::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'tags' => 'nullable|string|max:255',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photos')) {
            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('note_photos', 'public');
                $photoPaths[] = $path;
            }
            $data['photos'] = $photoPaths;
        }


        $data['user_id'] = auth()->id();

        Note::create($data);

        return redirect()->route('notes.index')->with('success', 'Note created successfully.');
    }

    public function show(Note $note)
    {
        $this->authorizeAccess($note);
        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        $this->authorizeAccess($note);
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'tags' => 'nullable|string|max:255',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_photos' => 'nullable|array',
        ]);

        // ✅ Handle photos properly
        $existingPhotos = $note->photos ?? [];

        // Remove photos
        if ($request->has('remove_photos') && is_array($request->remove_photos)) {
            foreach ($request->remove_photos as $photoToRemove) {
                if (($key = array_search($photoToRemove, $existingPhotos)) !== false) {
                    Storage::disk('public')->delete($photoToRemove);
                    unset($existingPhotos[$key]);
                }
            }
            $existingPhotos = array_values($existingPhotos);
        }

        // Add new photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('note_photos', 'public');
                $existingPhotos[] = $path;
            }
        }

        $data['photos'] = $existingPhotos;

        $note->update($data);

        return redirect()->route('notes.index')->with('success', 'Note updated successfully');
    }

    public function destroy(Note $note)
    {

        if ($note->photos) {
            foreach ($note->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }
        $this->authorizeAccess($note);
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note deleted.');
    }

    private function authorizeAccess(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }
    }
}
