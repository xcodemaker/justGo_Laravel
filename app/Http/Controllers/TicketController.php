<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use JWTAuth;
use QrCode;
use File;
use Storage;
use Image;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\TicketDetails;
use App\Train;

use Carbon\Carbon;
use Tymon\JWTAuth\Claims\Issuer;
use Tymon\JWTAuth\Claims\IssuedAt;
use Tymon\JWTAuth\Claims\Expiration;
use Tymon\JWTAuth\Claims\NotBefore;
use Tymon\JWTAuth\Claims\JwtId;
use Tymon\JWTAuth\Claims\Subject;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], 401);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        $ticketDetails = TicketDetails::create([
            'price' => $request->price,
            'class' => $request->classType,
            'date' => $request->date,
            'distance' => $request->distance,
            'time' => $request->time,
            'source' => $request->source,
            'destination' => $request->destination,
            // 'qr_code' => $request->contact_number,
            ]);

        $train = Train::create([
                'train_id' => $request->train_id,
                'train_no' => $request->train_no,
                'arrival_time' => $request->arrival_time,
                'departur_time' => $request->departur_time,
                'source' => $request->source,
                'destination' => $request->destination,
                'train_name' => $request->train_name,
                'train_type' => $request->train_type,
                'train_frequency' => $request->train_frequency,
                ]);

        $ticket = Ticket::create([
                'ticket_details_id' => $ticketDetails->id,
                'user_id' => $user->id,
                'train_id' => $train->id,
                ]);

        $ticket_id = $ticket->id;
        $message = 'Ticket created';
        $user_folder_path = storage_path().'/tickets/qrcodes/';

        $date = date('m-d-Y_his');

        $data = [
                'id' => $ticket_id,
                'iss' => new Issuer('justgo'),
                'iat' => new IssuedAt(Carbon::now('UTC')) ,
                'exp' => new Expiration(Carbon::now('UTC')->addDays(1)),
                'nbf' => new NotBefore(Carbon::now('UTC')),
                'sub' => new Subject('ticket'),
                'jti' => new JwtId($ticketDetails->id),
            ];

        $customClaims = JWTFactory::customClaims($data);
        $payload = JWTFactory::make($data);
        $token = JWTAuth::encode($payload);

        if (!File::exists($user_folder_path)) {
            File::makeDirectory($user_folder_path, 0777, true);
        }
        QrCode::format('png')->size(500)->generate($token->get(), $user_folder_path.$ticket_id.'.png');

        // Image::make();

        $qr_code = '';

        if (env('APP_ENV') != 'development') {
            $disk = Storage::disk('gcs');
            // return $file;
            $disk->put('tickets/qrcodes/'.$ticket_id.'.png', file_get_contents($user_folder_path.$ticket_id.'.png'));
            $disk->setVisibility('tickets/qrcodes/'.$ticket_id.'.png', 'public');
            $qr_code =$disk->url('tickets/qrcodes/'.$ticket_id.'.png');
        }

        TicketDetails::
            where('id', $ticketDetails->id)
            ->update(['qr_code' => $ticket_id.'.png']);
                
         
        return response()->json(compact('ticket_id', 'message', 'qr_code'), 201);
    }

    public function get_ticket_list(){
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], 401);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        $tickets = Ticket::with(['train','ticket_details'])
        ->where('user_id','=',$user->id)->select('id','train_id','ticket_details_id')
        ->get();
        return response()->json(['tickets'=>$tickets]);
    }

    public function validate_ticket(Request $request){
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], 401);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        $ticket = Ticket::with(['train','ticket_details','user.user_details'])
        ->where('id','=',$request->ticket_id)->select('id','train_id','ticket_details_id','user_id')
        ->first();
        return response()->json(['ticket'=>$ticket]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
