<?php
/**
 * @Author      : yoohip
 * @DateTime    : 2022/9/13 0013
 * @Description :
 */

namespace Yoohip\PhpCurl;

/**
 * Class HandlePhpCurl
 * @package Yoohip
 */
class HandlePhpCurl {

    /**
     * @param string $apiUrl
     * @param array $parameter
     * @param string $method
     * @return array
     */
    public static function handlePhpCurl(string $method ,string $apiUrl,array $parameter=[])
    {
        $apiUrl = rtrim($apiUrl, '/');

        if ($method == '' || $apiUrl == '') {
            return [
                'code' => false,
                'msg' => '缺少参数！！！',
                'data' => [],
            ];
        }

        switch ($method)
        {
            case 'get':

                if ($parameter) {
                    $str = http_build_query($parameter);
                    $apiUrl = $apiUrl.'?'.$str;
                }
                $res = self::getUrl($apiUrl);
                break;

            case 'post':
                $res = self::postUrl($apiUrl, $parameter);
                break;

            case 'put':
                $res = self::putUrl($apiUrl, $parameter);
                break;
            case 'del':
                $res = self::delUrl($apiUrl, $parameter);
                break;

            case 'patch':
                $res = self::patchUrl($apiUrl, $parameter);
                break;
            default:
                $res = [];
                break;
        }

        $res = [
            'code' => true,
            'msg' => '',
            'data' => $res,
        ];

        return $res;
    }

    /**
     * get
     * @param $url
     * @return mixed
     */
    private static function getUrl($url)
    {
        $headerArray = array("Content-type:application/json;", "Accept:application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }

    /**
     * post
     * @param $url
     * @param $data
     * @return mixed
     */
    private static function postUrl($url,$data){
        $data  = json_encode($data);
        $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output, true);
    }

    /**
     * put
     * @param $url
     * @param $data
     * @return mixed
     */
    private static function putUrl($url,$data){
        $data = json_encode($data);
        $ch = curl_init(); //初始化CURL句柄
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"PUT"); //设置请求方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置提交的字符串
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output,true);
    }

    /**
     * del
     * @param $url
     * @param $data
     */
    private static function delUrl($url,$data){
        $data  = json_encode($data);
        $ch = curl_init();
        curl_setopt ($ch,CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output,true);
    }

    /**
     * patch
     * @param $url
     * @param $data
     * @return mixed
     */
    private static function patchUrl($url,$data)
    {
        $data = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }
}
