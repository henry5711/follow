<?php

namespace App\Observers;

use App\Models\images;
use App\Models\post;
use Illuminate\Support\Facades\Storage;

class PostObserver
{
    /**
     * Handle the post "created" event.
     *
     * @param  \App\Models\post  $post
     * @return void
     */
    public function created(post $post)
    {
        //
    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Models\post  $post
     * @return void
     */
    public function updated(post $post)
    {
        //
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Models\post  $post
     * @return void
     */
    public function deleting(post $post)
    {
        $del=images::where('id_post',$post->id)->value('contenido');
                Storage::delete($del);

    }

    /**
     * Handle the post "restored" event.
     *
     * @param  \App\Models\post  $post
     * @return void
     */
    public function restored(post $post)
    {
        //
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param  \App\Models\post  $post
     * @return void
     */
    public function forceDeleted(post $post)
    {
        //
    }
}
