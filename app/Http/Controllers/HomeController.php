<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Book;
use Illuminate\Support\Facades\Auth;
use App\Sector;
use App\City;
use App\People;
use App\Misollar;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function hisoblash(Request $request)
    {
        // $kredit = new Book();

        $foiz=(float)$_POST['foiz'];
        $oy=(float)$_POST['oy'];
        $pul=(float)$_POST['pul'];

        $statik=$pul/$oy;
        $stafka=$foiz/1200;

        $oylar = [];
        for($i=1;$i<=$oy;$i++)
        {
            $oylar[] = [$i,$pul,$statik,$pul*$stafka,$statik+$pul*$stafka] ;
            $pul-=$statik;
        }
        
       return view('answer',[
            'oylars'=>$oylar
       ]);

    } 

    public function welcome() {
        $get  = DB::table('books')->get();
        return view('welcome',[
            'books'=>$get
        ]);
    }
    public function answer(Request $request) 
    {
        $a = DB::table('misollars')->get();
        return view('answer',
            [
                'answers'=>$a
            ]);
    }
    public function user_delete($id) {
        $del = new People();
        $del ->where('id',$id)->delete();
        return back();
    }
    public function user_edit($id, Request $request) 
    {
       $people = DB::table('people')->where('id',$id)->first();
        
        return view('edit_people',
            [
                'peoples'=>$people
            ]);
    }
    public function natija_edit_save($id, Request $request)
    {
        // dd($request);
        $edit = new People();
        $result = $_POST['result'];
        $edit->where('id',$id)->update(
            [
                'natija'=>$result, 
                // 'userImage'=>$file
            ]); 
        return redirect('/table');
    }
    public function user_add()
    {
        $sec = json_encode(Sector::all(),true);
        // dd($sec);
        $city = City::All();
        // dd($city);
        $tumanlar = [];
        foreach ($city as $key => $cit) {
            $new = [];
            $new["name"] = $cit["name"];
            $new["id"] = $cit["id"];
            $tumanlar[$cit->sector_id][] = $new;
        }

        $tumanlar = json_encode($tumanlar,true);
       
        $asos = DB::table('asoslars')->get();
        $people = DB::table('people')->get();

        $tumanlar = DB::table('cities')->get();
        $sector = DB::table('sectors')->get();
        return view('user_add',
            [
                'sectors'=>$sec,
                'citys'=>$tumanlar,
                'asoslars'=>$asos,
                'peoples'=>$people,
                'tumanlars'=>$tumanlar,
                'sectors'=>$sector,
            ]
    );
    }
    public function admin_add()
    {
        return view('admin_add');
    }
    public function ishlash(Request $request) 
    {
        
        $s = new Misollar();

        $X = []; 
        $Y = [];
        $y = 0;
        $n = count($_POST);
        $n = $n-1;
        for ($i=0;   $i < $n-1;   $i++){
            
            if($i % 2 ==0) {
                $X[] = (float)$_POST[(string)$i];
                }
            else{
               
                $Y[] = (float)$_POST[(string)$i];
                
            } 

        }
        $masX = implode(",", $X);
        $masY = implode(",", $Y);
        $s->y0 = $masY;
        $s->x0 = $masX;
        
        $s->x = $_POST['x'];
        $s->n = $n;
        $user = Auth::user()->name;
        $s->name = $user;

        $Li = 1.0;
        $x = (float)$_POST['x'];
        // dd($x);
        for ($i=0;   $i < ($n-1)/2;   $i++)
               {
                
                $Li = 1.0;

                for ($j=0;   $j < ($n-1)/2;   $j++)
                    {
                     if ($j != $i) 
                        {
                         $Li = ($Li * ($x - $X[$j])) / ($X[$i] - $X[$j]);
                        }
                    }

                $y += ($Y[$i] * $Li);

               }

        $s->answer = $y;
        $s->save();      
        return view('javob',['javob'=>$y]);
    }

    public function user_add_save(Request $request)
    {
        // dd($request);
        $book = new Book();
        $rasm = 'img'.(string)\date('Y-m-d\TH-i-s').'.jpg';

          //dd( $request->file('exp'));
        $request->file('img')->storeAs('image', $rasm, 'public');

        $file = 'file'.(string)\date('Y-m-d\TH-i-s').'.pdf';

          //dd( $request->file('exp'));
        $request->file('file')->storeAs('file', $file, 'public');

        $book->name=$_POST['name'];
        $book->type=$rasm;
        $book->file=$file;

        $book->save();
        return redirect('/home');
    }
    public function admin_add_save(Request $request) 
    {
        $admin = new User();
        $admin->name = $_POST['name'];
        $admin->email = $_POST['email'];
        $admin->password = Hash::make($_POST['parol']);

        $admin->save();
        return redirect('/table');
    }
    public function table(Request $request)
    {
        $view = People::all();
        $sector = DB::table('sectors')->get();
        $tumanlar = DB::table('cities')->get();
        $a = request()->get('a');
        $b = request()->get('b');
        $city=null;
        if(!empty($a)){
            $city = DB::table('cities')->where('sector_id',$a)->get();
            $people = DB::table('people')->where('sector_id',$a)->get();
        }
        else {
            if(!empty($b)){
            $city = DB::table('cities')->where('id',$b)->first();
            $d=$city->sector_id;
            $city = DB::table('cities')->where('sector_id',$d)->get();
            $people = DB::table('people')->where('city_id',$b)->get();

        }
        else{
            $people = DB::table('people')->get();
            }
        }
        $user = DB::table('users')->get();
        // dd($view);
        return view('table',
            [
                'sectors'=>$sector,
                'views'=>$view,
                'users'=>$user,
                'citys'=>$city,
                'peoples'=>$people,
                'tumans'=>$tumanlar,
                'b'=>$b,
                'a'=>$a,
                'taminlanganlar'=>0,
                'taminlanmaganlar'=>0,
            ]
    );
    
    }
}
