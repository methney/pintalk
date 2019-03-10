<?php
namespace App\Http\Controllers;
class AboutController extends Controller {

    public function showAbout()
    {
        return 'ABOUT content';
    }

    public function showSubject($theSubject)
    {
        return $theSubject.' content';
    }

    public function showDirections()
    {
        $theUrl = URL::route('directions');
        return "DIRECTIONS go on this URL: $theUrl";
    }

}