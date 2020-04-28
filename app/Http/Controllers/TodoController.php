<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $allTodos = $this->getAllTasks();

        return $allTodos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $todo = new Todo();
        $todo->user_id = Auth::user()->id;
        $todo->todoName = $request->todoName;
        $todo->isDone = 0;

        $todo->save();

        $allTodos = $this->getAllTasks();

        return $allTodos;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
        $todo->todoName = $request->todoName;
        $todo->update();
    }


    /**
     * Removes the specified resource in storage.
     *
     * @param Request $request
     * @param Todo $todo
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Request $request, Todo $todo)
    {
        $todo->delete();

        $allTodos = $this->getAllTasks();

        return $allTodos;
    }


    /**
     * retrieve resource data from storage
     *
     * @param $id
     * @return mixed
     */
    public function getTodo($id)
    {
        return Todo::find($id);
    }


    /**
     * Update completed state to the opposite of current value
     *
     * @param Request $request
     * @return mixed
     */
    public function changeDoneState(Request $request)
    {
        $todo = Todo::find($request->id);

        $todo->isDone = ($todo->isDone) ? 0 : 1; // Assign to opposite of current value
        $todo->update();

        $allTodos = $this->getAllTasks();

        return $allTodos;
    }

    /**
     * Get all pending tasks from storage
     *
     * @return mixed
     */
    private function getAllActiveTodos()
    {
        return Todo::where('isDone', false)->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
    }

    /**
     * Get all completed tasks from storage
     *
     * @return mixed
     */
    private function getAllCompletedTodos()
    {
        return Todo::where('isDone', true)->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
    }

    /**
     * Gather both pending and completed tasks from storage
     *
     * @return mixed
     */
    private function getAllTasks()
    {
        $allTodos['pending'] = $this->getAllActiveTodos();
        $allTodos['completed'] = $this->getAllCompletedTodos();

        return $allTodos;
    }

    public function uploadImage($form_data)
    {
        return 'Upload kickass';
    }
}
