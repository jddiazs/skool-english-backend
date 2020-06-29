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
    $file      = $request->file('file');

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
    }
    $publicPath = public_path($folder);
    $attachData['file_path'] = '/public/'.$folder;
    $attachData['name']   = date('His').'-'.$attachData['original_name'];

    $file->move($publicPath, $attachData['name']);
    $attach = Attachment::create($attachData);

    return response()->json(['path' => $attachData['file_path'].DIRECTORY_SEPARATOR.$attachData['name'], 'attach' => $attach], 200);
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
