<?php

use think\Response;
// 应用公共文件

//政治面貌
function pol_cou_select(){
    return [
        '中国共产党党员',
        '中国共产党预备党员',
        '中国共产党党员(保留团籍)',
        '中国共产主义青年团团员',
        '中国国民党革命委员会会员',
        '中国民主同盟盟员',
        '中国民主建国会会员',
        '中国民主促进会会员',
        '中国农工民主党党员',
        '中国致公党党员',
        '九三学社社员',
        '台湾民主自治同盟盟员',
        '无党派民主人士',
        '中国少年先锋队队员',
        '群众'
    ];
}
//最高学历
function hight_edu_select(){
    return [
        '博士研究生',
        '硕士研究生',
        '大学本科',
        '大学专科',
        '中等专科',
        '职业高中',
        '技工学校',
        '高中',
        '初中',
        '小学',
        '其他'
    ];
}

//从业状况
function occupation_select(){
    return [
        '国家公务员(含参照、依照公务员管理)',
        '专业技术人员',
        '职员',
        '企业管理人员',
        '工人',
        '农民',
        '学生',
        '教师',
        '现役军人',
        '自由职业者',
        '个体经营者',
        '无业人员',
        '退(离)休人员',
        '其他'
    ];
}

//居住区域
function area_select(){
    return [
        '桥东区',
        '桥西区',
        '宣化区',
        '下花园区',
        '万全区',
        '崇礼区',
        '张北县',
        '康保县',
        '沽源县',
        '尚义县',
        '蔚县',
        '阳原县',
        '怀安县',
        '怀来县',
        '涿鹿县',
        '赤城县',
        '经济技术开发区',
        '察北管理区',
        '塞北管理区'
    ];
}

/**
 * 获取用户真实IP
 * @return string
 */
function getIP() {
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
    }
    elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    }
    elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
    }
    elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');

    }
    elseif (getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
    }
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function checkTel($tel){
    if (!preg_match("/^1[3456789]\d{9}$/", $tel)) {
        return false;
    }else{
        return true;
    }
}
function checkPassword($password){
    if (!preg_match('/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9]{8,20}/',$password)) {
        return false;
    }else{
        return true;
    }
}

 function requests($url, $data = array(), $method = 'POST', $header = array(), $multi = false) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if (preg_match('|^https|i', $url)) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    if ($header) {
//        curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    switch (strtoupper($method)) {
        case 'GET':
            !empty($data) && $url .= '?' . http_build_query($data);
            break;
        case 'POST' :
            $data = $multi ? $data : http_build_query($data);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            break;
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    $content = curl_exec($ch);
    // var_dump(curl_error($ch));
    curl_close($ch);
    return $content;
}

/**
 * curl
 * @param $url
 * @param array $data
 * @param string $method
 * @param array $header
 * @param bool $multi
 * @return mixed
 */
function curl_request($url, $data = array(), $method = 'POST', $header = array(), $multi = false)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if (preg_match('|^https|i', $url)) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    if ($header) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    switch (strtoupper($method)) {
        case 'GET':
            !empty($data) && $url .= '?' . http_build_query($data);
            break;
        case 'POST' :
            $data = $multi ? $data : http_build_query($data);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            break;
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    $content = curl_exec($ch);
    //错误信息
    $errno = curl_errno( $ch );
    $info  = curl_getinfo( $ch );
    $info['errno'] = $errno;
    $info['errmsg']=curl_error($ch);
    curl_close($ch);
    return $content;
}



/**
 * 发送http post 请求，发送到api接口，已经写好了apikey,如果需要登录需要传入Authorization值，Authorization从前端获取
 *
 * @param string $type  类型，array、json类型
 * @param $data 提交参数，类型需要和 type 一致
 * @param $Authorization 权限验证参数，
 * @param $url  提交地址
 * @return mixed|string
 */
function sendPostRequest($url,$content=NULL,$authorization=NULL,$type = NULL){

    $content = is_null($content)?array():$content;
    $head_key = array('apikey:'.config('api.api_key'));  // apikey

    $ch = curl_init();
    if(substr($url,0,5)=='https'){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
    }
    curl_setopt($ch, CURLOPT_URL, $url);

    // 用户加密信息
    if (!empty($authorization)){
        $head_key = array('apikey:'.config('api.api_key'),'Authorization:'.$authorization);
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $head_key);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $content);

    if ($type == "json") {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json; charset=utf-8",
                "Content-Length: " . strlen($content))
        );
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $tmpInfo = curl_exec($ch);
    if (curl_errno($ch)) {
        return curl_error($ch);
    }
    curl_close($ch);
    return $tmpInfo;
}

