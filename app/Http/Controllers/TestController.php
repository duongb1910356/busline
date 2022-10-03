<?php

namespace App\Http\Controllers;

use App\Models\BenXe;
use App\Models\LichTrinh;
use App\Models\NhanVien;
use App\Models\TaiKhoan;
use App\Models\Ve;
use App\Models\GiaVe;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Sunra\PhpSimple\HtmlDomParser;

use Symfony\Component\DomCrawler\Crawler;
use PDO;

class TestController extends Controller
{
    public function test()
    {
        $html = file_get_contents("img/icon/nhaxe.html");
        $crawler = new Crawler($html);
        $crawler = $crawler->filter('a[data-medium="Item-1"]');
        // var_dump($crawler);

        foreach ($crawler as $domElement) {
            var_dump($domElement->nodeValue);
        }
    }
}
