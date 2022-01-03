<?php

namespace App\Observers;

use App\Models\Menu;
use App\Models\Menu as ModelsMenu;

class MenuObserver
{
    /**
     * Handle the Menu "created" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function created(Menu $menu)
    {
        //
    }

    /**
     * Handle the Menu "updated" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function updated(Menu $menu)
    {
        //
    }

    /**
     * Handle the Menu "deleted" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function deleting(Menu $menu)
    {
        if($menu->image != "noimage.png"){
            unlink(public_path('menu_images').'/'.$menu->image);
        }
    }

    /**
     * Handle the Menu "restored" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function restored(Menu $menu)
    {
        //
    }

    /**
     * Handle the Menu "force deleted" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function forceDeleted(Menu $menu)
    {
        //
    }
}
