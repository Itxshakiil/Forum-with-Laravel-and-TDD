<?php

namespace App;

use Illuminate\Support\Facades\Auth;

trait Favoritable{
    

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->user()->id];

        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }
    
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->user()->id];

        $this->favorites()->where($attributes)->delete();
    }

    public function isFavorited()
    {
        if(Auth::check()){
            return $this->favorites->where(['user_id' => auth()->user()->id])->count();
        }
        return false;
    }

    public function getIsFavoritedAttribute(){
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}