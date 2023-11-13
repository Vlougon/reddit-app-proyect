<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CommunityLink;
use Illuminate\Http\Request;
use App\Http\Requests\CommunityLinkForm;
use App\Queries\CommunityLinksQuery;
use Illuminate\Support\Facades\Auth;


class CommunityLinkControllerAPI extends Controller
{
    /**
     * Control to only allow auth users to enter the store, update and destroy endpoints.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('popular') && request()->exists('text')) {

            $links = CommunityLinksQuery::getByTitleAndPopular(trim(request()->input('text')));
        } else if (request()->exists('text')) {

            $links = CommunityLinksQuery::getByTitle(trim(request()->input('text')));
        } else if (request()->exists('popular')) {

            $links = CommunityLinksQuery::getMostPopular();
        } else {

            $links = CommunityLinksQuery::getAll();
        }

        return response()->json(['links' => $links], 200);
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

                return response()->json([['message' => 'Se ha actualizado el link Correctamente'], ['link' => $link]], 200);
            } else {

                return response()->json([['message' => 'El enlace ya está publicado y aprobado pero usted es un usuario no verificado, por lo que no se actualizará en la lista'], ['link' => $link]], 200);
            }
        } else {

            CommunityLink::create($data);

            if ($data['approved']) {

                return response()->json([['message' => 'Se ha creado el link Correctamente'], ['link' => $link]], 200);
            } else {

                return response()->json([['message' => 'Se ha hecho la contribución, pero usted no está legitimado'], ['link' => $link]], 200);
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
