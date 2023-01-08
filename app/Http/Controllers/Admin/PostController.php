<?php
/*
// si importa il modello con use
// CRUD
//  - index -> si prendono tutti i post
//  - create -> crea un nuovo post
//  - store -> salva un post
//  - show ->
//  - delete ->

*/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //fare la validazione prima di inserire dati in un db perchè i dati sono inseriti da un utente
        $request -> validate([
            'title'=>'required|max:250',
            'content'=>'required',
            'slug'=>'required|unique|max:'
        ]);
        $postData = $request->all();
        $newPost = new Post();
        $newPost->fill($postData);
        //generiamo in automatico lo slug dal titolo, niente validazione perchè generato automaticamente
        $slug = Str::slug($newPost->title);
        $alternativeSlug = $slug;
        //lo slug deve essere univoco quindi si controlla in db se esiste già.
        //prendo solo first perchè non mi serve tutta la lista ma solo uno (ce ne sarà solo uno)
        $postFound = Post::where('slug', $slug)->first();

        //se esiste già uno slug uguale si aggiunge un numero alla fine
        while($postFound) {
            $counter = 1;
            $alternativeSlug = $slug . '_' . $counter;
            $counter++;
            $postFound = Post::where('slug', $alternativeSlug)->first();
        }
        //vado a mettere come slug alternativeslug
        $newPost->slug = $alternativeSlug;
        //salviamo il post
        $newPost->save();
        //redirect
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
