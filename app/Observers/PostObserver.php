<?php

namespace App\Observers;

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
        if (isset($post->contenido)) {
            foreach ($post->contenido as $image){
                Storage::delete($image);
            }
        }
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