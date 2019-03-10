<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;
use View;
use Session;
use App\Exceptions\CustomException;

class PinController extends Controller {

    public function insertSingleFile(Request $request)
    {
        $imageExt = $request->file('file')->getClientOriginalExtension();
        $imageName = md5(date('YmdHis')).'.'.$imageExt;        

        $request->file('file')->move(
            base_path() . '/public/uploadImages/', $imageName
        );

        // displaying file    
        $array = array(
            //'filelink' => url().'/uploadImages/'.$imageName,
            'filelink' => '/uploadImages/'.$imageName,
            'fileName' => $imageName,
            'url' => '/uploadImages/'.$imageName
        );
        
        echo stripslashes(json_encode($array));   

        /*
        //dd($request); ajax의 경우, preview에서 return value 확인! 
        //var_dump($request);
        $result = DB::insert('insert into t_board_file (board_sno, reg_dt, idx, file_nm) values (?,sysdate(),?,?)', [
            $request->input('board_sno'), 
            $request->input('idx'),
            $request->input('file_nm')
        ]);
        */
        //return Response::json(Input::all());
        //return response()->json(['result' => $result],200);
        //return Response::json(['result' => $result]);
        //return Redirect::to('commonCode');
    }


    public function insertPinRepFile(Request $request)
    {
        
        $imageExt = $request->file('file')->getClientOriginalExtension();
        $imageName = md5(date('YmdHis')).'.'.$imageExt;        

        $request->file('file')->move(
            base_path() . '/public/uploadImages/', $imageName
        );

        // displaying file    
        $array = array(
            //'filelink' => url().'/uploadImages/'.$imageName
            'filelink' => $imageName
        );
        
        echo stripslashes(json_encode($array));   

    }


    public function insertPin(Request $request)
    {
        
        DB::beginTransaction();

        // board key
        $sel = $this->selectTop($request);
        $key = sizeof($sel)>0?$sel[0]->sno + 1:0;
        
        // pin 
        $result = DB::insert('insert into t_board (sno, board_id, title, owner, content
                                                    , hash_tag, rep_img, country, district, address
                                                    , lat, lng, category, reg_dt
                                                    ) values (?,?,?,?,?
                                                                ,?,?,?,?,?
                                                                ,?,?,?,sysdate())', [
            $key, 
            $request->input('board_id'),
            $request->input('title'),
            Auth::user()->email,
            $request->input('pin_content'),

            $request->input('hash'),
            $request->input('rep_img'),
            $request->input('country'),
            $request->input('district'),
            $request->input('address'),

            $request->input('lat'),
            $request->input('lng'),
            $request->input('category') 
        ]);

        /*
        if(Input::hasFile('file')){
            // pin file
            $result = DB::insert('insert into t_board_file (board_sno, reg_dt, idx, file_nm) values (?,sysdate(),?,?)', [
                $key, 
                $request->input('idx'),
                $request->input('file_nm')
            ]);
        }
        */

        // input file name, before this actuall file already were uploaded!
        $f_idx = 1;
        $files = Input::get('filenames');

        if(sizeof($files)>0){
            foreach($files as $val){
                $result = DB::insert('insert into t_board_file (board_sno, reg_dt, idx, file_nm) values (?,sysdate(),?,?)', [
                    $key, 
                    $f_idx,
                    $val
                ]);
                $f_idx++;
            }
        }
        
        // foursquare pins 
        $fourPinUse = $request->get('fourUse');
        $fourPinIds = $request->get('fourPinIds');
        $fourPinNames = $request->get('fourPinNames');
        $fourPinCateIds = $request->get('fourPinCateIds');
        $fourPinCateNames = $request->get('fourPinCateNames');
        $fourPinLats = $request->get('fourPinLats');
        $fourPinLngs = $request->get('fourPinLngs');
        $fourPinIcons = $request->get('fourPinIcons');
        $fourPinCheckinCnts = $request->get('fourPinCheckinCnts');
        $fourPinUserCnts = $request->get('fourPinUserCnts');
        $fourPinUrls = $request->get('fourPinUrls');
        $fourPinRatings = $request->get('fourPinRatings');
        $fourPinAddresses = $request->get('fourPinAddresses');

        if(sizeof($fourPinIds)>0){
            foreach($fourPinUse as $useIdx=>$useValue){
                foreach($fourPinIds as $idx=>$value){

                    if($useValue-1==$idx){
                        $fourResult = DB::insert('insert into t_foursquare_pin (
                        board_sno, pin_id, pin_name, category_id, category_name
                        , icon, lat, lng, url, checkin_cnt
                        , user_cnt, rating, address, reg_dt) 
                        values ( ?,?,?,?,?
                        ,?,?,?,?,?
                        ,?,?,?,sysdate())
                        ',[
                            $key, 
                            $fourPinIds[$idx], 
                            $fourPinNames[$idx], 
                            $fourPinCateIds[$idx], 
                            $fourPinCateNames[$idx]
                            , $fourPinIcons[$idx], 
                            $fourPinLats[$idx], 
                            $fourPinLngs[$idx], 
                            $fourPinUrls[$idx],
                            $fourPinCheckinCnts[$idx]
                            , $fourPinUserCnts[$idx],
                            $fourPinRatings[$idx],
                            $fourPinAddresses[$idx]
                        ]);

                        // save photo
                        $fourPinPhotos = $request->input('fourPinPhoto'.$idx);
                        if($fourPinPhotos){
                            foreach($fourPinPhotos as $photoIdx=>$photoValue){
                                DB::insert('insert into t_foursquare_pin_photo (
                                pin_id, board_sno, url, reg_dt) values (?,?,?,sysdate()) 
                                ',[$fourPinIds[$idx],$key,$photoValue]);
                            }
                        }

                        // save comment
                        $fourCommentUser = $request->input('fourCommentUser'.$idx);
                        $fourCommentDate = $request->input('fourCommentDate'.$idx);
                        $fourComment = $request->input('fourComment'.$idx);

                        if($fourCommentUser){
                            foreach($fourCommentUser as $commentIdx=>$commentValue){
                                DB::insert('insert into t_foursquare_pin_comment (
                                pin_id, board_sno, user, write_dt, comment, reg_dt) values (?,?,?,?,?,sysdate())
                                ',[$fourPinIds[$idx],$key,$commentValue,$fourCommentDate[$commentIdx],$fourComment[$commentIdx]]);
                            }
                        }
                    }
                }
            }
        }

        // youtube
        $youtubePinIds = $request->get('yPinId');
        $youtubeTitles = $request->get('yTitle');
        $youtubeVideos = $request->get('yVideoId');

        if(sizeof($youtubeVideos)>0){
            foreach($youtubePinIds as $youIdx=>$youValue){
                DB::insert('insert into t_youtube (
                    pin_id, board_sno, title, video_id, reg_dt) values (?,?,?,?, sysdate())
                ',[$youValue, $key, $youtubeTitles[$youIdx],$youtubeVideos[$youIdx]]);
            }
        }

        DB::commit();        
        /*
        //dd($request); ajax의 경우, preview에서 return value 확인! 
        //var_dump($request);
        $result = DB::insert('insert into t_board_file (board_sno, reg_dt, idx, file_nm) values (?,sysdate(),?,?)', [
            $request->input('board_sno'), 
            $request->input('idx'),
            $request->input('file_nm')
        ]);
        */
        //return Response::json(Input::all());
        //return response()->json(['result' => $result],200);
        //return Response::json(['result' => $result]);

        Session::set('lat', $request->input('lat'));
        Session::set('lng', $request->input('lng'));

        //return Redirect::to('indexGuest')->with(['fromRegister'=>true, 'key'=>$key]); 
        return Redirect::route('indexGuestWithKey',['key'=>$key]);
    }

    public function selectTop(Request $request){
        $result = DB::select('
            select	sno
            from	t_board
            where   board_id = ?
            order by sno desc
            limit 1
        ', [$request->input('board_id')]);

        return $result;
    }

    
    public function selectPins(Request $request){

        $keyword = $request->input('keyword');
        if(!isset($keyword)){
            $keyword = '';
        }
        $category = Input::get('category');
        $newCategory = '';
        if($category!=null){
            $newCategory = ' and p.category in (';
            foreach($category as $key=>$value){
                if($key!=0) $newCategory.=',';
                $newCategory .= '"'.$value.'"';
            }
            $newCategory .= ') ';
        }

        $rep_where =   ($request->input('id')!='')?' and p.sno = "'.$request->input('id').'" ':'';
        $rep_where .= ($request->input('keyword')!='')?' and p.title like concat("%","'.$keyword.'","%") ':'';
        $rep_where .= ($newCategory!='')?$newCategory:'';
        $rep_where .= ($request->input('start')!='')?' and p.sno < '.$request->input('start'):'';

        /*
        $idx_start = $request->input('start');
        $idx_end = $request->input('end');
        */

        $paging = '';
        if($request->input('pageCnt')!=''){
            $paging = 'order by p.sno desc limit '.$request->input('pageCnt');
        }

        $results = DB::select("
        select	p.sno, p.title, p.content, p.category, c.cd_nm category_name, p.owner, p.address, p.lat, p.lng, p.reg_dt, f.file_nm, r.score_quality, r.score_host, trim(p.hash_tag) as hash_tag, u.name host_name, u.avatar host_avatar, u.link host_link, u.aboutme host_aboutme, u.location host_location, u.lat host_lat, u.lng host_lng, u.facebook_id, four.pin_count
        from	t_board p
        left outer join t_user u on p.owner = u.email
        left outer join (
            select	board_sno, group_concat(file_nm) file_nm
            from	t_board_file
            group by board_sno
        ) f on p.sno = f.board_sno
        left outer join t_board_review r on p.sno = r.board_sno
        left outer join t_common_code c on p.category = c.cd_nm
        left outer join (
            select board_sno, count(pin_id) pin_count
            from	t_foursquare_pin
            group by board_sno
        )four on p.sno = four.board_sno 
        where   1=1 ".$rep_where." ".$paging 
        );

        $arr = array();
        if(sizeof($results)>0){
            foreach($results as $key=>$value ){
                $arr[$key]['sno'] = $value->sno;
                $arr[$key]['id'] = $key+1;
                if($value->file_nm!=''){
                    $farr = explode(",", $value->file_nm);
                    $arr[$key]['gallery'] = $farr;
                }
                $arr[$key]['description'] = $value->content;
                $arr[$key]['title'] = $value->title;
                $arr[$key]['category'] = $value->category;
                $arr[$key]['category_name'] = $value->category_name;
                $arr[$key]['type'] = $value->category;
                $arr[$key]['location'] = $value->address;
                $arr[$key]['latitude'] = $value->lat;
                $arr[$key]['longitude'] = $value->lng;
                $arr[$key]['date_created'] = $value->reg_dt;
                $arr[$key]['owner'] = $value->owner;
                $arr[$key]['type_icon'] = '/assets/icons/offices/interior/wifi.png';
                $arr[$key]['score_quality'] = $value->score_quality;
                $arr[$key]['score_host'] = $value->score_host;
                $arr[$key]['hash'] = $value->hash_tag;
                $arr[$key]['file_name'] = $value->file_nm;

                $arr[$key]['host_name'] = $value->host_name;
                $arr[$key]['host_avatar'] = $value->host_avatar;
                $arr[$key]['host_link'] = $value->host_link;
                $arr[$key]['host_aboutme'] = $value->host_aboutme;
                $arr[$key]['host_location'] = $value->host_location;
                $arr[$key]['host_lat'] = $value->host_lat;
                $arr[$key]['host_lng'] = $value->host_lng;
                $arr[$key]['facebook_id'] = $value->facebook_id;
                $arr[$key]['pin_count'] = $value->pin_count;
            }
        }

        $fourResult = array();
        if($request->input('id')!=''){
            $fourResult = DB::select('
                select  *
                from    t_foursquare_pin
                where   1=1
                and     board_sno = ?
            ',[$request->input('id')]);
        }

        return Response::json(['data'=>$arr, 'four'=>$fourResult]);
    }

    // 대화수락후 핀정보를 가져갈때, 핀에 대한 대화가 수락됐음을 로그에 저장 
    public function selectPinUserInfo(Request $request){

        DB::beginTransaction();

        if($request->input('pin_id')==0) DB::rollBack();

        $email = array();
        array_push($email, $request->get('email'));
        array_push($email, $request->get('subscriber'));
    
        // t_chat_room key
        $sel = $this->selectTopRoom($request);
        $key = sizeof($sel)>0?$sel[0]->sno + 1:0;
        
        // pin 
        $result = DB::insert('insert into t_chat_room (sno, pin_sno, reg_dt
                                                         ) values (?,?,sysdate())', [
            $key, 
            $request->input('pin_id'),
        ]);

        // user 등록 
        if(sizeof($email)>0){
            foreach($email as $val){
                $result = DB::insert('insert into t_chat_room_user (room_sno, user_email, reg_dt) values (?,?,sysdate())', [
                    $key,
                    $val
                ]);
            }
        }

        
        $rep_where = ' and email in (';
        foreach($email as $key=>$value){
            if($key!=0) $rep_where .= ',';
            $rep_where.= '"'.$value.'"';
        }
        $rep_where .= ') ';

        $results = DB::select('
            select	*
            from	t_user
            where	1=1 '.$rep_where
        );

        $arr = array();
        if(sizeof($results)>0){
            foreach($results as $key=>$value){
                $arr[$key]['name'] = $value->name;
                $arr[$key]['email'] = $value->email;
                $arr[$key]['avatar'] = $value->avatar;
            }
        }

        DB::commit(); 

        return Response::json($arr);
    }
 
    // indexGuest
    public function selectPinDetail(Request $request){
        $result = DB::select('
            select  *
            from    t_board p 
            left outer join t_user u on p.owner = u.email
            where   p.sno = ?

        ',[$request->input('id')]);

        $result_pin = DB::select('
            select  *
            from    t_foursquare_pin
            where   board_sno = ?
        ',[$request->input('id')]);

        $result_comment = DB::select('
            select  *
            from    t_foursquare_pin_comment
            where   board_sno = ?
        ',[$request->input('id')]);

        $result_photo = DB::select('
            select  *
            from    t_foursquare_pin_photo 
            where   board_sno = ?
        ',[$request->input('id')]);

        $result_youtube = DB::select('
            select  *
            from    t_youtube 
            where   board_sno = ?
        ',[$request->input('id')]);


        return Response::json(['board'=>$result, 'board_pin'=>$result_pin, 'board_pin_comment'=>$result_comment, 'board_pin_photo'=>$result_photo, 'board_pin_youtube'=>$result_youtube]);
    }


    public function selectUserInfo(Request $request){
        /*
        $result = DB::select('
            select  t.email, t.name, t.level, t.facebook_id, t.avatar, t.id, t.link, t.aboutme, t.video_enable, t.audio_enable, t.lat, t.lng, t.location, p.title, p.reg_dt, p.sno
            from    t_board p 
            left outer join t_user t on t.email = p.owner
            where   p.owner = ?
            order by p.reg_dt desc
        ',[$request->input('email')]);
        */

        $result = DB::select('
            select	*
            from	t_user user 
            where 	user.email = ?
        ',[$request->input('email')]);

        return Response::json($result); 
    }


    public function selectPinUserHas(Request $request){

        $result = DB::select('
            select  *
            from    t_board p 
            where   p.owner = ?
            order by p.reg_dt desc
        ',[$request->input('email')]);

        return Response::json($result); 

    }


    public function selectPinList(Request $request){
        $start = $request->input('page')*$request->input('listCnt')+1;
        $results = DB::select('
        select	p.sno, p.title, p.content, p.category, p.owner, p.address, p.lat, p.lng, p.reg_dt, f.file_nm, r.score_host, trim(p.hash_tag) as hash_tag
        from	t_board p
        left outer join (
            select	board_sno, group_concat(file_nm) file_nm
            from	t_board_file
            group by board_sno
        ) f on p.sno = f.board_sno
        left outer join t_board_review r on p.sno = r.board_sno 
        where   1=1 
        limit 20 offset ?
        ',[$start]);
        return View::make('pin/pinGridList')->with('results',$results);
    }


    public function selectTopRoom(Request $request){
        $result = DB::select('
            select	sno
            from	t_chat_room
            order by sno desc
            limit 1
        ');

        return $result;
    }


    public function directAccess($pin_id){
        $result = DB::select('
            select  *
            from    t_board 
            where   1=1
            and     sno = ?
        ',[$pin_id]);

        $lat = $result[0]->lat;
        $lng = $result[0]->lng;
        $owner = $result[0]->owner;

        return view('indexMap', ['pin_id' => $pin_id, 'direct_access' => true, 'lat'=>$lat, 'lng'=>$lng, 'owner'=>$owner]);
    }


    public function directPage($pin_id){
        
        $result = DB::select('
            select  *
            from    t_board 
            where   1=1
            and     sno = ?
        ',[$pin_id]);

        if(sizeof($result)==0){
            throw new CustomException();
        }

        $lat = $result[0]->lat;
        $lng = $result[0]->lng;

        return view('indexGuest', ['pin_id' => $pin_id, 'direct_access' => true, 'lat'=>$lat, 'lng'=>$lng]);

    }


    public function modifyHostPin($pin_id){

        $result = DB::select('
            select  p.sno, p.board_id, p.category, p.title, p.owner, p.country, p.district, p.address, p.lat, p.lng, p.hash_tag, p.reg_dt, p.content, p.rep_img, p.grade, p.ing, u.email, u.name, u.facebook_id, u.avatar, u.level, u.id, u.link, u.aboutme, u.video_enable, u.audio_enable, u.location, u.lat user_lat, u.lng user_lng
            from    t_board p 
            left outer join t_user u on p.owner = u.email
            where   p.sno = ? and p.owner = ?
        ',[$pin_id, Auth::user()->email]);

        if(sizeof($result)==0){
            return view('indexHost', ['pin_id' => $pin_id, 'modify' => 'not_allowed']);
        }
        return view('indexHost', ['pin_id' => $pin_id, 'modify' => 'modify', 'board'=>$result]);
    }


    public function fourPinForIndexHost(Request $request){
        $result_pin = DB::select('
            select  *
            from    t_foursquare_pin
            where   board_sno = ?
        ',[$request->input('pin_id')]);

        $result_comment = DB::select('
            select  *
            from    t_foursquare_pin_comment
            where   board_sno = ?
        ',[$request->input('pin_id')]);

        $result_photo = DB::select('
            select  *
            from    t_foursquare_pin_photo 
            where   board_sno = ?
        ',[$request->input('pin_id')]);

        $result_youtube = DB::select('
            select  *
            from    t_youtube 
            where   board_sno =?
        ',[$request->input('pin_id')]);


        return Response::json(['board_pin'=>$result_pin, 'board_pin_comment'=>$result_comment, 'board_pin_photo'=>$result_photo, 'board_pin_youtube'=>$result_youtube]);
    }


    public function insertReview(Request $request){
        $result = DB::insert('
            insert into t_board_review 
            (board_sno, score_quality, score_host, reg_dt) values (?, ?, ?, sysdate())
        ',[$request->input('pin_id'), $request->input('score_quality'), $request->input('score_host') ]);

        return Response::json($result);
    }

    
    public function selectPinForDetail(Request $request){
        $result = DB::select('
            select  max(p.sno) sno
                    , max(p.title) title
                    , max(p.owner) owner
                    , max(p.address) address 
                    , max(p.category) category
                    , max(p.lat) lat
                    , max(p.lng) lng 
                    , max(p.reg_dt) reg_dt 
                    , max(p.content) content 
                    , max(p.hash_tag) hash_tag
                    , max(p.grade) grade 
                    , max(p.ing) ing 
                    , max(r.title) review_title
                    , max(r.content) review_content 
                    , round(sum(r.score_quality)/count(r.board_sno)) score_quality 
                    , round(sum(r.score_host)/count(r.board_sno)) score_host 
                    , max(r.reg_dt) review_reg_dt
                    , count(r.board_sno) cnt 
            from    t_board p
            left outer join t_board_review r on p.sno = r.board_sno
            where   1=1
            and     p.sno = ?
            group by r.board_sno
        ',[$request->input('pin_id')]);

        $files = DB::select('
            select  *
            from    t_board_file 
            where   board_sno = ?
        ',[$request->input('pin_id')]);

        return View::make('pin/pinDetail')->with(['result'=>$result[0], 'files'=>$files]);
        
    }


    public function updatePin(Request $request)
    {
        
        DB::beginTransaction();
        $files = Input::get('filenames');
        // 대표이미지용이라 새로운이미지가 업로드되지 않았다면 이전 이미지를 지우지 않는다.
        if(sizeof($files)>0){
            DB::delete('delete from t_board_file where board_sno = ?',[$request->input('sno')]);
        }

        // delete before...
        DB::delete('delete from t_board where sno = ? ',[$request->input('sno')]);
        DB::delete('delete from t_foursquare_pin where board_sno = ?',[$request->input('sno')]);
        DB::delete('delete from t_foursquare_pin_photo where board_sno = ?',[$request->input('sno')]);
        DB::delete('delete from t_foursquare_pin_comment where board_sno = ?',[$request->input('sno')]);


        $key = $request->input('sno');
        
        // pin 
        $result = DB::insert('insert into t_board (sno, board_id, title, owner, content
                                                    , hash_tag, rep_img, country, district, address
                                                    , lat, lng, category, reg_dt
                                                    ) values (?,?,?,?,?
                                                                ,?,?,?,?,?
                                                                ,?,?,?,sysdate())', [
            $key, 
            $request->input('board_id'),
            $request->input('title'),
            Auth::user()->email,
            $request->input('pin_content'),

            $request->input('hash'),
            $request->input('rep_img'),
            $request->input('country'),
            $request->input('district'),
            $request->input('address'),

            $request->input('lat'),
            $request->input('lng'),
            $request->input('category') 
        ]);

        /*
        if(Input::hasFile('file')){
            // pin file
            $result = DB::insert('insert into t_board_file (board_sno, reg_dt, idx, file_nm) values (?,sysdate(),?,?)', [
                $key, 
                $request->input('idx'),
                $request->input('file_nm')
            ]);
        }
        */

        // input file name, before this actuall file already were uploaded!
        $f_idx = 1;
        $files = Input::get('filenames');

        if(sizeof($files)>0){
            foreach($files as $val){
                $result = DB::insert('insert into t_board_file (board_sno, reg_dt, idx, file_nm) values (?,sysdate(),?,?)', [
                    $key, 
                    $f_idx,
                    $val
                ]);
                $f_idx++;
            }
        }
        
        // foursquare pins 
        $fourPinUse = $request->get('fourUse');
        $fourPinIds = $request->get('fourPinIds');
        $fourPinNames = $request->get('fourPinNames');
        $fourPinCateIds = $request->get('fourPinCateIds');
        $fourPinCateNames = $request->get('fourPinCateNames');
        $fourPinLats = $request->get('fourPinLats');
        $fourPinLngs = $request->get('fourPinLngs');
        $fourPinIcons = $request->get('fourPinIcons');
        $fourPinCheckinCnts = $request->get('fourPinCheckinCnts');
        $fourPinUserCnts = $request->get('fourPinUserCnts');
        $fourPinUrls = $request->get('fourPinUrls');
        $fourPinRatings = $request->get('fourPinRatings');
        $fourPinAddresses = $request->get('fourPinAddresses');

        if(sizeof($fourPinIds)>0){
            foreach($fourPinUse as $useIdx=>$useValue){
                foreach($fourPinIds as $idx=>$value){

                    if($useValue-1==$idx){
                        $fourResult = DB::insert('insert into t_foursquare_pin (
                        board_sno, pin_id, pin_name, category_id, category_name
                        , icon, lat, lng, url, checkin_cnt
                        , user_cnt, rating, address, reg_dt) 
                        values ( ?,?,?,?,?
                        ,?,?,?,?,?
                        ,?,?,?,sysdate())
                        ',[
                            $key, 
                            $fourPinIds[$idx], 
                            $fourPinNames[$idx], 
                            $fourPinCateIds[$idx], 
                            $fourPinCateNames[$idx]
                            , $fourPinIcons[$idx], 
                            $fourPinLats[$idx], 
                            $fourPinLngs[$idx], 
                            $fourPinUrls[$idx],
                            $fourPinCheckinCnts[$idx]
                            , $fourPinUserCnts[$idx],
                            $fourPinRatings[$idx],
                            $fourPinAddresses[$idx]
                        ]);

                        // save photo
                        $fourPinPhotos = $request->input('fourPinPhoto'.$idx);
                        if($fourPinPhotos){
                            foreach($fourPinPhotos as $photoIdx=>$photoValue){
                                DB::insert('insert into t_foursquare_pin_photo (
                                pin_id, board_sno, url, reg_dt) values (?,?,?,sysdate()) 
                                ',[$fourPinIds[$idx],$key,$photoValue]);
                            }
                        }

                        // save comment
                        $fourCommentUser = $request->input('fourCommentUser'.$idx);
                        $fourCommentDate = $request->input('fourCommentDate'.$idx);
                        $fourComment = $request->input('fourComment'.$idx);

                        if($fourCommentUser){
                            foreach($fourCommentUser as $commentIdx=>$commentValue){
                                DB::insert('insert into t_foursquare_pin_comment (
                                pin_id, board_sno, user, write_dt, comment, reg_dt) values (?,?,?,?,?,sysdate())
                                ',[$fourPinIds[$idx],$key,$commentValue,$fourCommentDate[$commentIdx],$fourComment[$commentIdx]]);
                            }
                        }
                    }
                }
            }
        }


        DB::commit();        
        /*
        //dd($request); ajax의 경우, preview에서 return value 확인! 
        //var_dump($request);
        $result = DB::insert('insert into t_board_file (board_sno, reg_dt, idx, file_nm) values (?,sysdate(),?,?)', [
            $request->input('board_sno'), 
            $request->input('idx'),
            $request->input('file_nm')
        ]);
        */
        //return Response::json(Input::all());
        //return response()->json(['result' => $result],200);
        //return Response::json(['result' => $result]);

        Session::set('lat', $request->input('lat'));
        Session::set('lng', $request->input('lng'));

        $redirectUrl = '/indexHost/'.$request->input('sno');
        return redirect($redirectUrl);
    }

    public function deletePin(Request $request)
    {
        DB::beginTransaction();

        // delete before...
        DB::delete('delete from t_board where sno = ? ',[$request->input('sno')]);
        DB::delete('delete from t_board_file where board_sno = ?',[$request->input('sno')]);
        DB::delete('delete from t_foursquare_pin where board_sno = ?',[$request->input('sno')]);
        DB::delete('delete from t_foursquare_pin_photo where board_sno = ?',[$request->input('sno')]);
        DB::delete('delete from t_foursquare_pin_comment where board_sno = ?',[$request->input('sno')]);
        DB::delete('delete from t_youtube where board_sno = ?',[$request->input('sno')]);

        DB::commit();    
        return Redirect::to('indexGuest'); 
    }
    /*
    public function testfunction(Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')){    
            return response()->json(['response' => 'This is post method']); 
        }

        return response()->json(['response' => 'This is get method']);
        
        
        // $response = array(
        //     'status' => 'success',
        //     'msg' => 'Setting created successfully',
        // );
        // return Response::json($response);
    }
    */

}