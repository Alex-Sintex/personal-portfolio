<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\Level;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LessonController extends Controller
{
    const NUMBER_OF_ITEMS_PER_PAGE = 25;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::paginate(self::NUMBER_OF_ITEMS_PER_PAGE);
        return Inertia('Lessons/Index', [
            'lessons' => $lessons
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $levels = Level::all();
        return Inertia('Lessons/Create', [
            'categories' => $categories,
            'levels' => $levels
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonRequest $request)
    {
        // Save the lesson
        $lesson = Lesson::create([
            'name' => $request->name,
            'description' => $request->description,
            'content_uri' => $request->content_uri,
            'level_id' => $request->level_id
        ]);

        // Relacionar categorías (muchos a muchos)
        if ($request->categories) {
            $lesson->categories()->sync($request->categories);
        }

        // Redirigir a la lista de lecciones con mensaje
        return redirect()->route('lessons.index')->with('success', 'Lesson created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        $categories = Category::all();
        $levels = Level::all();

        return Inertia::render('Lessons/Edit', [
            'lesson' => $lesson,
            'categories' => $categories,
            'levels' => $levels,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->validated());

        // Sync the categories if it's a many-to-many relation
        if ($request->has('categories')) {
            $lesson->categories()->sync($request->categories);
        }

        return redirect()->route('lessons.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('lessons.index');
    }
}
