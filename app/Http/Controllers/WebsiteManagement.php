<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Jenssegers\Agent\Agent;

class WebsiteManagement extends Controller
{
    public function Sliders(Request $request)
    {

        $data =  DB::table("sliders")->get();

        return view("admin.sliders", compact("data"));
    }

    public function SaveSlider(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'file' => 'required',

        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $count = 0;
            foreach ($messages->all() as $error) {
                if ($count == 0)
                    return redirect()->back()->with('error', $error);

                $count++;
            }
        }

        $file = "";
        if ($request->hasFile('file')) {
            $file = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move('sliders', $file);
        }

        try {
            $data = [
                "image" => $file,
                "heading1" => $request->heading1,
                "heading2" => $request->heading2,

            ];
            DB::table('sliders')->where("id", 1)->update($data);
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }






    public function Sliders1(Request $request)
    {

        $data =  DB::table("sliders1")->orderBy("id", "desc")->get();

        return view("admin.sliders1", compact("data"));
    }

    public function SaveSlider1(Request $request)
    {


        $file = "";
        if ($request->hasFile('file')) {
            $file = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move('sliders', $file);
        }
        try {
            $data = [
                "image" => $file,
                "link" => $request->link,
            ];
            if ($request->id) {
                DB::table('sliders1')->where("id", $request->id)->delete();
            } else {
                DB::table('sliders1')->insert($data);
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }





    public function Sliders2(Request $request)
    {

        $data =  DB::table("sliders2")->orderBy("id", "desc")->get();

        return view("admin.sliders2", compact("data"));
    }

    public function SaveSlider2(Request $request)
    {


        $file = "";
        if ($request->hasFile('file')) {
            $file = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move('sliders', $file);
        }
        try {
            $data = [
                "image" => $file,
                "link" => $request->link,
            ];
            if ($request->id) {
                DB::table('sliders2')->where("id", $request->id)->delete();
            } else {
                DB::table('sliders2')->insert($data);
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }
}
