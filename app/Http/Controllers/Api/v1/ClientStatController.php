<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\ClientStat;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\PaginatorController;
use App\Http\Controllers\Api\v1\ResponseConstructorController;
use App\Http\Middleware\ValidatorRules;
use App\Http\Controllers\Controller;
use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ClientStatPublished;
use Illuminate\Support\Facades\Http;

class ClientStatController extends ResponseConstructorController
{

    public function SendNotifyToTelegram($message)
    {
        // Notification::send('test', new ClientStatPublished('test'));
        // return Http::get('https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN', '') . '/sendMessage?chat_id=645535275&text=' . $message);
        return Http::post(
            'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN', '') . '/sendMessage?chat_id=645535275&text=' .
            $message);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $res = ClientStat::orderBy('created_at', 'desc')->get();

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

        $validator = ValidatorRules::MakeValidate($request, 'client_stats');
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 400);
        }
        try {

            $newStat = ClientStat::create($request->all());
            // dd(collect($newStat['blob']));
            $notify = 'IP: ' . $newStat['IP'] . ' Instance: ' . $newStat['instance'] . ' ' .
                'https://stat.cv.blkdem.ru/api/v1/stat/read/' . $newStat['id'];

            // dd($notify);

            $telegramResponse = $this->SendNotifyToTelegram($notify);
            $newStat['response'] = $telegramResponse;
            return $this->sendSuccess($newStat, "Stat Added", false, 201);
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
