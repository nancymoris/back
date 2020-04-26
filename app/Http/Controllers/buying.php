<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cat;
use App\prod_user;
use App\prod;

class buying extends Controller
{
    public function getSession(Request $req,$id){
        if($req->session()->has($id))
            print_r($req->session()->get($id));
    }

    public function setSession(Request $req,$id,$qty=1){
        //if(isset($id)) {
        if($req->session()->has($id))
        {
           
            $q=$req->session()->get($id);
            echo "var Q=".$q;
            $qty=$qty+$q;
            echo "var Qty=".$qty;
            $req->session()->forget($id);
            $req->session()->put($id,$qty);
        }
        else
        {
            echo "put=Qty".$qty;
            $req->session()->put($id,$qty);
        }
        return redirect()->back();
    }

    public function forgetSession(Request $req,$id='jjjjjjjjjjjjjj',$qty=1){
        if($req->session()->has($id))
             $req->session()->forget($id);
        
    }

    // public function allSession(Request $req){
    //          print_r($req->session()->all());
    // }


    public function pageCart()
    {
        $temp=0;
        $products=prod::all();
        return view('Clothing-website.cart')->with(
            [
                'prods'=>$products,
                'temp'=>$temp
            ]);
    }

    public function allSession(Request $req){

        foreach(session()->all() as $key => $obj)
        {
            
            //$prodImg=time() . '.' . $req->img->getClientOriginalExtension();
            $p = new prod_user();
            return $obj;
            $p->prod_id =$key;
            $p->quantity =$obj;
            $p->user_id=1;
            $p->save();
            
        }
        return redirect(route('cart'));
    }
    public function update1(Request $req,$id){
        return "hhhhhhhhhhhhhh";
        $req->session()->forget($id);
        $req->session()->put($id,$req->input($id));
        return redirect(route('cart'));
    }

    public function update(Request $req){
        $prods=prod::all();
        foreach($prods as $prod){
            if($req->input($prod->id)){
                $req->session()->forget($prod->id);
                $req->session()->put($prod->id,$req->input($prod->id));
            }
        }
        return redirect(route('cart'));
    }

}
