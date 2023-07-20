<?php

namespace App\Http\Controllers;

use App\Models\ClientStat;
use Illuminate\Http\Request;
use App\Http\Controllers\PaginatorController;
use App\Http\Controllers\ResponseConstructorController;
use App\Http\Middleware\ValidatorRules;

class ClientStatController extends ResponseConstructorController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $res = ClientStat::orderBy('created_at', 'asc')->get();

        $paginator = PaginatorController::Paginate($res->count(), 1, 1);

        return $this->sendResponse($res, "Statistic info", $paginator);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [];
        $data['userAgent'] = $request->userAgent();
        $data['server'] = $request->server();
        $data['header'] = $request->headers;
        $data['query'] = $request->query();

        // dd($data);

        $request['IP'] = $request->server()['REMOTE_ADDR'];

        $request['browser'] = (isset($request['browser'])) ?: $data['userAgent'];

        $blob = [
            'client_blob' => $request['blob'],
            'server_blob' => $data
        ];

        $request['blob'] = json_encode( $blob );

        // dd($request->all());

        $validator = ValidatorRules::MakeValidate($request, 'client_stats');
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 400);
        }
        try {

            $newStat = ClientStat::create($request->all());
            return $this->sendSuccess($newStat, "Stat Added", 201);
        }
        catch (\Exception $e) {
            return $this->sendError('Creating Record Error: ' . $e, 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientStat $clientStat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientStat $clientStat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientStat $clientStat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientStat $clientStat)
    {
        //
    }
}
