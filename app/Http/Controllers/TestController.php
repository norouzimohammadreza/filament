<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
       $c=  $this->getAllModels();
       dd($c);
    }
    public function getAllModels()
    {
        $modelList = [];
        $path = app_path() . "/Models";
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename = $result;
            if (is_dir($filename)) {
                $modelList = array_merge($modelList, getModels($filename));
            }else{
                $modelList[] = substr($filename,0,-4);
            }

        }
        return $modelList;
    }
    public function getClass()
    {
       $x = explode('\\',get_class(auth()->user()));
       dd(strtolower($x[2].'s'));
    }
    public function x()
    {
        Category::x();
    }
}
