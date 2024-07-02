<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use DateTime;
use Cake\Filesystem\Folder;


/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class HomesController extends AppController
{

    public $today;

    public function initialize(): void
    {
        parent::initialize();
        $this->today = (new DateTime())->format('Ymd');
        $this->logo = WWW_ROOT . 'img/logo100_100.png';

        $this->json_file = WWW_ROOT . "datas/data_tiktok_" . $this->today . ".json";
        $this->json_video = WWW_ROOT . "videos/json/data_tiktok_" . $this->today . ".json";

        $this->file_video_path = WWW_ROOT . "videos/movies/{id}/";
        $this->list_video_name = WWW_ROOT . "videos/join_video_name/list_video_name_" . $this->today . ".txt";
    }


    public function getImage(){
        // $html = file_get_html('https://www.fotor.com/images/inspiration');
        // $rets = $html->find('.CustomWaterFall_gallery-waterfall-container__1e_OF img');
        // dd($rets);
        // foreach ($rets as $key => $ret) {
        //     // if ($key == 1) break;
            
        // }
    }

    public function getSound()
    {

        $html = file_get_html('https://nhacdj.vn/nhac-Nonstop-c5.html?page=45');
        $rets = $html->find('.song-list .song-name a');

        $mh = curl_multi_init();
        $curl_handles = [];

        foreach ($rets as $key => $ret) {
            // if ($key == 1) break;
            $html2 = file_get_html($ret->href);
            $media = $html2->find('#media-player source')[0];
            $name = str_replace([' ', '/'], ['_', '_'], $ret->plaintext);

            $src = $media->src;
            $exp = explode('.', $src);
            $ext = end($exp);
            $path_sound = __('{0}sounds/nhacdj/{1}.{2}', WWW_ROOT, $name, $ext);
            $file_handle = fopen($path_sound, 'w');
            $ch = curl_init($src);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FILE, $file_handle);

            $curl_handles[] = $ch;
            curl_multi_add_handle($mh, $ch);
        }

        $active = null;
        do {
            curl_multi_exec($mh, $active);
        } while ($active > 0);

        foreach ($curl_handles as $ch) {
            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);
        }

        curl_multi_close($mh);
    }


    public function index()
    {

        $is_get_list_data_json = $this->request->getQuery('get_list_data_video');
        // từ trang https://savetiktok.io/ sẽ gọi về để lấy danh sách id video
        if (!is_null($is_get_list_data_json) && intval($is_get_list_data_json) == 1) {
            // lấy danh sách id video từ file data/data_tiktok_<date>.json
            // xử lý lấy data ở đây
            $data = [];
            $json = file_get_contents($this->json_file);
            $data = json_decode($json, true);
            // echo json_encode(['data' => $data]);
            echo json_encode(['data' => $data]);
            exit();
        }

        $list_file = [];
        // $list_file = scandir(WWW_ROOT . 'videos/movies');
        // foreach ($list_file as $file) {
        //     if (strpos('DS_Store', $file) !== false || strpos('.', $file) !== false || strpos('..', $file) !== false || !is_dir(WWW_ROOT . 'videos/movies/' . $file)) continue;
        //     // $exp_id = explode('.mp4', $file);
        //     // if (count($exp_id) != 2) continue;

        //     $id = $file;

        //     $file_video_path = str_replace('{id}', $id, $this->file_video_path);
        //     // if (is_dir($file_video_path)) continue;
        //     // new Folder($file_video_path, true, 0777);

        //     $file_video = WWW_ROOT . 'videos/movies' . DS . $file . DS . $file . '.mp4';
        //     $file_gif = $file_video_path . $id . '.gif';

        //     // tạo ảnh gif từ video mới được tải về 
        //     exec(CONFIG . "/libs/ffmpeg -i " . $file_video . " -vf 'fps=24,scale=100:-1:flags=lanczos' -c:v gif " . $file_gif, $o, $c);
        //     if ($c == 0) {
        //         $result = $file_video_path . 'result.mp4';
        //         exec(CONFIG . "/libs/ffmpeg -i " . $file_video . " -i " . $this->logo . " -i " . $file_gif . " -filter_complex '[0:v][1:v]overlay=5:5[watermark1];[watermark1][2:v]overlay=W-w-5:H-h-5' -c:a copy " . $result, $o2, $c2);
        //     }
        // }

        // get all gif of video in folder movies
        $this->set('lists', $list_file);
    }


    public function tiktokDatas()
    {
        $datas = $this->request->getData('datas');
        // dữ liệu truyền từ console của tiktok.com về
        // lưu vào thành file json có tên là datas/data_tiktok_<date>.json
        // xử lý lưu file ở đây
        $fp = fopen($this->json_file, 'w');
        fwrite($fp, json_encode($datas));
        fclose($fp);

        echo json_encode(['success' => ['ok']]);
        exit();
    }


    public function saveTiktokDatas()
    {
        $datas = $this->request->getData('videos');
        // dữ liệu truyền từ console của https://savetiktok.io/ về
        // lưu vào thành file json có tên là ./videos/json/data_tiktok_<date>.json
        // xử lý lưu file ở đây
        $fp = fopen($this->json_video, 'w');
        fwrite($fp, $datas);
        fclose($fp);

        echo json_encode(['success' => ['ok']]);
        exit();
    }


    public function getAndSaveVideos()
    {
        if (!is_file($this->json_video)) {
            echo json_encode(['404' => 'File not found!']);
            exit();
        }
        $jsonVideo = file_get_contents($this->json_video);
        $dataVideo = json_decode($jsonVideo, true);

        $dataVideo = $dataVideo ?: [];
        $text_content = '';

        if (empty($dataVideo)) {
            echo json_encode(['data' => 'empty']);
            exit();
        }
        foreach ($dataVideo as $video) {

            if (!isset($video['videoid'][0]) || !isset($video['video'][0])) continue;

            $file_video_path = str_replace('{id}', $video['videoid'][0], $this->file_video_path);
            if (!is_dir($file_video_path)) {
                new Folder($file_video_path, true, 0777);
            }

            $file_video = $file_video_path . $video['videoid'][0] . '.mp4';
            $file_gif = $file_video_path . $video['videoid'][0] . '.gif';

            $download = downloadUrlToFile($video['video']['0'], $file_video);

            if ($download) {
                $text_content .= "file " . $file_video . "\n";

                // tạo ảnh gif từ video mới được tải về 
                exec(CONFIG . "/libs/ffmpeg -i " . $file_video . " -vf 'fps=24,scale=100:-1:flags=lanczos' -c:v gif " . $file_gif, $o, $c);
                if ($c == 0) {
                    $result = $file_video_path . 'result.mp4';
                    exec(CONFIG . "/libs/ffmpeg -i " . $file_video . " -i " . $this->logo . " -i " . $file_gif . " -filter_complex '[0:v][1:v]overlay=5:5[watermark1];[watermark1][2:v]overlay=W-w-5:H-h-5' -c:a copy " . $result, $o2, $c2);
                }
            }
            // 
        }
        // lưu trữ tên video đã được download về vào file text
        if ($text_content != '') file_put_contents($this->list_video_name, $text_content);

        echo json_encode(['success' => 'ok']);
        exit();
    }


    public function getImg()
    {
        $id = $this->request->getQuery('video_id');
        echo json_encode(is_file(WWW_ROOT . 'videos/movies/' . $id . '/' . $id . '.gif') ? ['src' => '/videos/movies/' . $id . '/' . $id . '.gif'] : []);
        exit();
    }


    public function uploadVideo()
    {
        $output = WWW_ROOT . 'results/' . $this->today . '.mp4';
        $ids = $this->request->getData('ids');
        $text_content = array_reduce($ids, fn ($o, $id) => $o . ("file " . WWW_ROOT . "videos/movies/" . $id . "/result.mp4\n"), '');
        $input_file = WWW_ROOT . 'results/' . $this->today . '.txt';
        if ($text_content != '') file_put_contents($input_file, $text_content);
        exec(CONFIG . '/libs/ffmpeg -f concat -safe 0 -i ' . $input_file . ' -c:v copy -c:a copy ' . $output, $o, $c);
    }
}
