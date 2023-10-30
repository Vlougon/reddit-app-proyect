<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityLinkForm;
use App\Models\Channel;
use App\Models\CommunityLink;
use App\Queries\CommunityLinksQuery;
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

        if (request()->exists('search')) {

            $links = CommunityLinksQuery::getByTitle(trim(request()->input('search')));
        } else {

            if (request()->exists('popular')) {

                if ($channel != null) {
                    $links = CommunityLinksQuery::getMostPopularByChannel($channel);
                } else {
                    $links = CommunityLinksQuery::getMostPopular();
                }
            } else {

                if ($channel != null) {
                    $links = CommunityLinksQuery::getByChannel($channel);
                } else {

                    $links = CommunityLinksQuery::getAll();
                }
            }
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
