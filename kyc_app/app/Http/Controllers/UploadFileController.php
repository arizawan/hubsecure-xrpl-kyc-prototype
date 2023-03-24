<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UploadFileController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        $destinationPath = storage_path() . '/app/public/';

        $doc_front = $request->file('doc_front');
        $gen_doc_front_name = Str::uuid()->toString() . "_" . str($doc_front->getClientOriginalName());
        $doc_front->move($destinationPath, $gen_doc_front_name);
        $doc_back = $request->file('doc_back');
        $gen_doc_back_name = Str::uuid()->toString() . "_" . str($doc_back->getClientOriginalName());
        $doc_back->move($destinationPath, $gen_doc_back_name);

        $live_photo = $request->live_photo; // your base64 encoded
        $live_photo = str_replace('data:image/jpeg;base64,', '', $live_photo);
        $live_photo = str_replace(' ', '+', $live_photo);
        $imageName = Str::uuid()->toString() . '.' . 'jpeg';
        \File::put($destinationPath . $imageName, base64_decode($live_photo));

        $outputArray = array(
            "id_data" => "",
            "doc_front" => $destinationPath . "" . $gen_doc_front_name,
            "doc_back" => $destinationPath . "" . $gen_doc_back_name,
            "live_photo" => $destinationPath . "" . str($imageName),
            "cust_id_number" => $request->input("cust_id_number"),
            "name" => $user->name,
            "user_id" => $user->id,
            "cust_dob" => $request->input("cust_dob"),
            "document_type" => $request->input("document_type"),
            "status" => "processing",
            "encryption_key" => "",
            "mimetype" => "",
            "filesize" => "",
            "type" => "",
            "block_data" => "",
            "block_uuid" => "",
        );

        $request = Http::withHeaders(
            [
                'Accept' => 'application/json',
            ]
        );

        $uploadContents = [
            'cust_name' => $outputArray["name"],
            'cust_dob' => $outputArray["cust_dob"],
            'doc_number' => $outputArray["cust_id_number"],
            'doc_type' => $outputArray["document_type"],
        ];

        try {
            $response = $request
                ->attach(
                    'doc_front', file_get_contents($outputArray["doc_front"]), str($gen_doc_front_name) . ""
                )
                ->attach(
                    'doc_back', file_get_contents($outputArray["doc_back"]), str($gen_doc_back_name) . ""
                )
                ->attach(
                    'live_photo', file_get_contents($outputArray["live_photo"]), str($imageName) . ""
                )
                ->post(
                    env('XRPL_API_HOST') . 'kyc/upload', $uploadContents
                );
            $outputArray["id_data"] = json_encode($response->json());
            $outputArray["block_uuid"] = $response->json()["uuid"];
            Files::create($outputArray);
            return redirect('/kyc/list');
        } catch (\Illuminate\Http\Client\RequestException$e) {
            \Log::info($e->getMessage());
            return $e->getMessage();
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function show(Files $files)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function edit(Files $files)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Files $files)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function destroy(Files $files)
    {
        //
    }
}
