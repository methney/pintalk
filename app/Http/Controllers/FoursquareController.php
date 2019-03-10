<?php namespace App\Http\Controllers;

use Session;
use App\User;
use Socialize;
use DB;
use Redirect;
use Auth;
use View;
use Illuminate\Http\Request;
use Input;
use URL;
use Larasquare;
use Response;

// https://github.com/iivannov/larasquare
// api참고 https://developer.foursquare.com/docs/ 
class FoursquareController extends Controller
{
    public function fourPins(Request $request){
        $coordi = $request->input('lat').','.$request->input('lng');

        
        if($request->input('category')=='explore'){
            $searchQuery = [
                'll'=>$coordi,
                'radius'=>$request->input('radius'),
                'limit'=>$request->input('limit')
            ];
            $venues = Larasquare::request("venues/explore/", $searchQuery);
        }else{
            $searchQuery = [
                'll'=>$coordi,
                'query'=>$request->input('keyword'),
                'categoryId'=>$request->input('category'),
                'radius'=>$request->input('radius'),
                'limit'=>$request->input('limit')
                //'v'=>'20170330'
            ];
            $venues = Larasquare::venues($searchQuery);
        }
        
        //dd($venues);
        return Response::json($venues);
    }

    // categories
    public function fourCategories(Request $request){
        //$response = Larasquare::request("venues/$venueId/photos");
        $response = Larasquare::request("venues/categories/");
        //dd($response);
        return Response::json($response);
    }

    // categories test
    public function fourTest(Request $request){
        $response = Larasquare::request("venues/categories/");
        dd($response);
    }
   
    // explore
    public function fourExplore(Request $request){
        $coordi = '51.54'.','.'-0.09';
        $searchQuery = [
            'll'=>$coordi,
            'query'=>$request->input('keyword'),
            'categoryId'=>$request->input('category'),
            'radius'=>$request->input('radius'),
            'limit'=>$request->input('limit'),
            'venuePhotos'=>1,
            'openNow'=>0
            //'oauth_token'=>'J0ECCV0FSCTRI2PZ5L3F2IERQP0FJEVK4LPOPI1HAV03R3MM',
            //'v'=>'20170330'
        ];
        $response = Larasquare::request("venues/explore/", $searchQuery);
        dd($response);
        //return Response::json($response);
    }

    // single venue itself
    public function fourPinVenue(Request $request){
        $response = Larasquare::venue($request->input('id'));
        return Response::json($response);
    }

    // single pin from db 
    public function selectSinglePin(Request $request){
        /*
        $pinResult = DB::select("
            select	pin.pin_id
                    , pin.pin_name
                    , pin.board_sno
                    , pin.category_id
                    , pin.category_name
                    , pin.icon
                    , pin.lat
                    , pin.lng
                    , pin.url
                    , pin.checkin_cnt
                    , pin.user_cnt
                    , pin.rating
                    , pin.address
                    , photo.url photos
                    , comments.user users
                    , comments.write_dt write_dts
                    , comments.comment comments
            from	t_foursquare_pin pin 
            left outer join (
				select 	board_sno, pin_id, group_concat(url,'#/#') url
                from 	t_foursquare_pin_photo
                group by board_sno, pin_id
            )photo on pin.pin_id = photo.pin_id and pin.board_sno = photo.board_sno
            left outer join (
				select 	board_sno, pin_id
						, group_concat(user,'#/#') user
                        , group_concat(write_dt,'#/#') write_dt
                        , group_concat(comment,'#/#') comment
                from	t_foursquare_pin_comment 
                group by board_sno, pin_id
            ) comments on pin.pin_id = comments.pin_id and pin.board_sno = comments.board_sno
            where 	pin.board_sno = ? and pin.pin_id = ?
        ",[$request->input('sno'), $request->input('pin_id')]);
        */


        $pinResult = DB::select('
            select	pin.pin_id
                    , pin.pin_name
                    , pin.board_sno
                    , pin.category_id
                    , pin.category_name
                    , pin.icon
                    , pin.lat
                    , pin.lng
                    , pin.url
                    , pin.checkin_cnt
                    , pin.user_cnt
                    , pin.rating
                    , pin.address
            from	t_foursquare_pin pin 
            where 	pin.board_sno = ? and pin.pin_id = ?
        ', [$request->input('sno'), $request->input('pin_id')]);

        $photoResult = DB::select('
            select 	board_sno, pin_id, url
            from 	t_foursquare_pin_photo
            where 	board_sno = ? and pin_id = ?
        ', [$request->input('sno'), $request->input('pin_id')]);

        $commentResult = DB::select('
            select 	board_sno, pin_id
                    , user
                    , write_dt
                    , comment
            from	t_foursquare_pin_comment 
            where 	board_sno = ? and pin_id = ?
        ', [$request->input('sno'), $request->input('pin_id')]);


        $youtubeResult = DB::select('
            select 	board_sno, pin_id
                    , title
                    , video_id
            from	t_youtube
            where 	board_sno = ? and pin_id = ?
        ', [$request->input('sno'), $request->input('pin_id')]);

        return Response::json(['pin'=>$pinResult,'photo'=>$photoResult,'comment'=>$commentResult,'youtube'=>$youtubeResult]);

    }

}

/*

https://foursquare.com/oauth2/authenticate?client_id=925020&response_type=code&redirect_uri=https://localhost/pintalk



*/