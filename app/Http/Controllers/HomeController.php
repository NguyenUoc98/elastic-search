<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

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
        $tr = new GoogleTranslate('vi');

        if ($request->has('url') && $request->url != '') {

            // Lấy nội dung html cần lấy
            $html = file_get_html($request->url);
            $find = $request->html_tag . ($request->name_tag == 'class' ? '.' : '#') . $request->name;
            $title = $tr->translate(str_replace('-', ' - ', $html->find('title', 0)->plaintext));
            $html = $html->find($find, 0)->outertext;

            // Nếu lấy nội dung
            if ($request->type == 'content') {
                $result = '';
                $str = '';
                do {
                    // Giới hạn 5000 ký tự 1 lần dịch
                    $str = substr($html, 0, strlen($html) > 5000 ? 5000 : strlen($html));
                    $index = strrpos($str, ">") + 1;
                    $str = substr($html, 0, $index);
                    if ($str != '') {
                        // Dịch và xóa các dấu cách thừa
                        $lineTemp = $tr->translate(str_replace('>', ">\r\n", $str));
                        $search = [' "', ' =', ' .', '. ', ' / ', ' /', '/ ', '= '];
                        $replace = ['"', '=', '.', '.', '/', '/', '/', '='];
                        $result .= str_replace($search, $replace, $lineTemp);
                    }
                    $html = trim(substr($html, $index));
                } while (str_word_count($str) != 0);
                $content = html_entity_decode($result);
                
                return view('get_content', compact('content', 'title'));
            } else {
                // Nếu lấy thông số kĩ thuật
                $infoTable = str_get_html(html_entity_decode($tr->translate($html)));
                $result = [];
                foreach ($infoTable->find('p') as $row) {
                    $infoRow = $row->find('span');
                    $result[$infoRow[0]->plaintext] = $infoRow[1]->plaintext;
                }
                return view('get_content', compact('result'));
            }
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
