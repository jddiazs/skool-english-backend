<?php

namespace App\Http\Controllers;

use App\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadAttachmentController extends Controller
{

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function upload(Request $request) {

    $user = Auth::user();
    $attachData = [];
    $files      = $request->file('file');
    $response = [];
    if (!is_array($files)) {
      return response()->json(['path' =>  null, 'attach' => null], 200);
    }
    foreach ($files as $file) {
      $attachData['original_name'] = $file->getClientOriginalName();
      $attachData['file_size'] = $file->getSize();
      $attachData['created_by'] = $user->id;
      $extension = $file->getClientOriginalExtension();
      $attachData['type'] = $extension;

      $folder = 'img';
      if($extension == 'mp4') {
        $folder = 'video';
      } elseif ($extension == 'mp3') {
        $folder = 'audio';
      } elseif ($extension == 'pdf') {
        $folder = 'docs';
      }

      $publicPath = public_path($folder);
      $attachData['file_path'] = '/'.$folder;
      $attachData['name']   = date('His').'-'.$attachData['original_name'];

      $file->move($publicPath, $attachData['name']);
      $attach = Attachment::create($attachData);

      $response[] = ['path' =>  DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$attachData['name'], 'attach' => $attach];
    }

    if(count($response) == 1) {
      return response()->json($response[0], 200);
    } else  {
      return response()->json($response, 200);
    }

  }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Attachment $attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment)
    {
        //
    }
}
