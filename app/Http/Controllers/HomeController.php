<?php

namespace App\Http\Controllers;

use App\Test;
use App\Gtranslate;
use Illuminate\Http\Request;

include(app_path() . '\HTMLDom\SimpleHtmlDom.php');

class HomeController extends Controller
{
    private $perPage = 5;

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
    public function index(Request $request)
    {
        if ($request->has('key')) {
            if ($request->key == '') {
                $key = '*';
            } else {
                $key = $request->key;
            }
            $users = Test::rawSearch()
                ->query(['match' => ['description' => $key]])
                ->size(5)
                ->execute();
            // $users = Test::search('description:' . $key)->get();
            dd($users);
            return view('home', compact('users'));
        }
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
        return view('welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getContent(Request $request)
    {
        $gt = new Gtranslate();

        if ($request->has('url') && $request->url != '') {
            $page = mb_convert_encoding(file_get_contents($request->url), 'UTF-8', 'GB2312');
            $array = explode("\n", $page);

            foreach ($array as $index => $line) {
                if (preg_match("/\p{Han}+/u", $line)) {
                    $line = $gt->translate($line, 'vi', 'zh');
                    $array[$index] = str_replace("&#39;", "'", html_entity_decode($line));
                }
            }

            dd($array);

            $html = file_get_html($request->url);
            $infoTable = str_get_html(html_entity_decode($gt->translate($html->find('.InforBox', 0), 'vi', 'zh')));
            $result = [];
            foreach ($infoTable->find('p') as $row) {
                $infoRow = $row->find('span');
                $result[$infoRow[0]->plaintext] = $infoRow[1]->plaintext;
            }
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
        return view('get_content');
    }

    /**
     * Show the application html.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getHtml()
    {
        return view('home_page');
    }
}
