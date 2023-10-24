<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityLinkForm;
use App\Models\Channel;
use App\Models\CommunityLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Channel $channel = null)
    {
        $channels = Channel::orderBy('title', 'asc')->get();

        if ($channel != null) {
            $links = $channel->communityLinks()->where('approved', true)->latest('updated_at')->paginate(25);
        } else {
            
            $links = CommunityLink::where('approved', true)->latest('updated_at')->paginate(25);
        }

        return view('community/index', compact('links', 'channels', 'channel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommunityLinkForm $request)
    {
        $data = $request->validated();

        $link = new CommunityLink();
        $link->user_id = Auth::id();

        $approved = Auth::user()->estaLegitimado();

        $data['user_id'] = $link->user_id;
        $data['approved'] = $approved;

        if ($link->hasAlreadyBeenSubmitted($data['link'])) {

            if ($data['approved']) {

                return back()->with('success', 'Se ha actualizado el link Correctamente');
            } else {

                return back()->with('warning', 'El enlace ya está publicado y aprobado pero usted es un usuario no verificado, por lo que no se actualizará en la lista');
            }
        } else {

            CommunityLink::create($data);

            if ($data['approved']) {

                return back()->with('success', 'Se ha creado el link Correctamente');
            } else {

                return back()->with('warning', 'Se ha hecho la contribución, pero usted no está legitimado');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunityLink $communityLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityLink $communityLink)
    {
        //
    }
}
