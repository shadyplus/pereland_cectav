<?php
global $dir_name;


class BeforeRenderCallback
{

    private $callbacks;
    private $cwd;

    public function __construct($callbacks, $cwd = null)
    {
        $this->callbacks = $callbacks;
        $this->cwd = $cwd;
    }

    public function addCallback($callback)
    {
        $this->callbacks[] = $callback;
    }

    public function __invoke($content, $phase)
    {

        if ($this->cwd) {
            chdir($this->cwd);
        }

        $content = trim($content);
        foreach ($this->callbacks as $callback) {
            $content = $callback($content, $this->cwd);
        }
        return $content;
    }

    public function prepare()
    {
        foreach ($this->callbacks as $callback) {
            $callback->prepare();
        }
    }
}

class PrelandInjector
{

    public $redirectUrl;
    private $code;

    public function __invoke($content, $cwd)
    {
        return str_replace('</head>', $this->code . '</head>', $content);
    }

    public function prepare()
    {
        $this->code = $this->render();
    }

    private function render()
    {
        ob_start();
        incl('/lib/js.preland.php', array(
            'redirectUrl' => $this->redirectUrl,
        ));
        $code = ob_get_clean();
        return $code;
    }
}

class JsInjector
{

    public $redirectUrl;
    public $render_context;
    private $code;

    public $utm = [
        "utm_source" => '',
        "utm_medium" => '',
        "utm_campaign" => '',
        "utm_content" => '',
        "utm_term" => '',

        "sub1" => '',
        "sub2" => '',
        "sub3" => '',
        "sub4" => '',
        "sub5" => '',

        'fb_pixel' => '',
        'fb_verify' => '',
        'ya_pixel' => '',
        'tiktok_pixel' => '',
        'mail_pixel' => '',
        'google_pixel' => '',
        'google_adw_pixel' => '',
        'vk_pixel' => '',
        'topmail_pixel' => '',
        'yandex_metrika' => '',
    ];

    public function __construct($params, $render_context)
    {
        $this->render_context = $render_context;

        foreach ($this->utm as $key => $val) {
            $this->utm[$key] = clear_value(array_get($params, $key));
        }

        if ($render_context['fb_verify']) {
            $this->utm['fb_verify'] = $render_context['fb_verify'];
        }
    }

    public function __invoke($content, $cwd)
    {
        $content = preg_replace('#<(?!header)head([^>])*>#', '<head$1>' . "\n" . $this->code, $content, 1);
        return $content;
    }

    public function prepare()
    {
        $this->code = $this->render();
    }

    private function render()
    {
        global $dir_name;
        $pixels = $this->render_context['pixels'];

        if (isset($pixels)) {
            foreach ($pixels as $pixel_name) {
                if ($this->utm[$pixel_name]) {
                    $pixel_id = $this->utm[$pixel_name];
                    require_once($dir_name . '/pieces/trackers/' . $pixel_name . '.php');
                }

            }
        }
        incl('trackers.php');
    }
}

function incl($filename, $context = array())
{
    extract($context);
    global $dir_name;
    require($dir_name . '/' . $filename);
}

function countrySelect()
{

    global $offers, $offer;

    usort($offers, function ($a, $b) {
        return strcmp($a['country']['name'], $b['country']['name']);
    });

    ?>
    <input type="hidden" name="sub1" value="{subid}"/>
    <input type="hidden" name="country" value="<?php echo $offer['country']['code']; ?>">
    <select name="offer" class="form-control country_chang" <?= count($offers) === 1 ?  'style="display: none;"' : ''?>>
        <?php foreach ($offers as $offerData): ?>
            <option
                    data-country-code="<?php echo $offerData['country']['code'] ?>"
                <?php if ($offerData['id'] == $offer['id']): ?>
                    selected="selected"
                <?php endif ?>
                    value="<?php echo $offerData['id'] ?>"
            >
                <?php echo $offerData['country']['name'] ?>
            </option>
        <?php endforeach ?>
    </select>
    <?php
}

function countryDefault()
{

    global $offer;
    ?>
    <input type="hidden" name="sub1" value="{subid}"/>
    <select name="offer" class="form-control country_chang" style="display: none;">
        <option
                data-country-code="<?php echo $offer['country']['code']; ?>"
                selected="selected"
                value="<?php echo $offer['id'] ?>"
        >
            <?php echo $offer['country']['name'] ?>
        </option>
    </select>

    <?php
}

function footer($id = 2)
{
    incl("pieces/footer.{$id}.php");
}

function normalizePrice($price)
{
    if (null !== $price) {
        if (intval($price) == $price) {
            $price = intval($price);
        }
    }
    return $price;
}

function clear_value($input_text)
{
    $input_text = strip_tags($input_text);
    $input_text = htmlspecialchars($input_text);
    return $input_text;
}

function array_get($array, $key, $default = null)
{
    if (is_array($array) && array_key_exists($key, $array)) {
        return $array[$key];
    } else {
        return $default;
    }
}


function get_country($ip_address, $offers, $offer)
{
    // Подключаем SxGeo.php класс
    include(__DIR__ . '/geo/SxGeo.php');
    $SxGeo = new SxGeo(__DIR__ . '/geo/SxGeo.dat');

    $countryDetect = $SxGeo->get($ip_address);

    return $countryDetect;
}

function get_offer_by_ip($ip_address, $offers, $offer)
{

    $country_code = get_country($ip_address, $offers, $offer);
    $offerDetected = $offer;
    foreach ($offers as $offerData) {
        if ($offerData['country']['code'] == $country_code) {
            $offerDetected = $offerData;
        }
    }
    return $offerDetected;
}

function is_debug($set_display_error = False, $unset_cookie = False)
{
    // Проверяем включен ли debug mod
    global $_debug, $apiKey, $landKey, $dbg_mod;

    $dbg_mod = False;

    if ($_debug) {
        $dbg_mod = True;
    }

    if (isset($_GET['dbg']) && 1 == $_GET['dbg'] && isset($_GET['key']) && $apiKey == $_GET['key']) {
        $dbg_mod = True;

        // устанавливаем куку
        setcookie("dbg_hash", md5($landKey . $apiKey));
    } elseif ($unset_cookie && !$_debug) {
        setcookie("dbg_hash");
    }

    if (isset($_COOKIE['dbg_hash'])) {
        if ($_COOKIE['dbg_hash'] == md5($landKey . $apiKey)) {
            $dbg_mod = True;
        }
    }

    if ($dbg_mod and $set_display_error) {
        error_reporting(E_ALL);
        ini_set('display_startup_errors', 1);
        ini_set('display_errors', '1');
    }

    return $dbg_mod;
}

function display_debug_info($title, $data)
{
    // выводит информацию об ошибках
    global $dbg_mod;
    if ($dbg_mod) {
        echo '<h3>' . $title . '</h3>';
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}

function add_fb_pixel($url, $fb_parameter_name, $fb_parameter_value)
{
    if ($url == '{offer}') {
        $new_url = $url . '&' . $fb_parameter_name . '=' . $fb_parameter_value;
    } else {
        $parts_url = parse_url($url);
        parse_str($parts_url['query'], $parts_query);
        $parts_query[$fb_parameter_name] = $fb_parameter_value;
        $parts_url['query'] = http_build_query($parts_query);
        $new_url = unparse_url($parts_url);
    }
    return $new_url;
}

function add_get_parameters($url, $parameters)
{
    /**
     * Функция добавляет в url дополнительные get-параметры.
     *
     * Если в исходном url уже есть get-параметры, то они сохраняются.
     *
     * @param $url string исходный url
     * @param $parameters array get-параметры (имя => значение)
     * @return string url с добавленными get-параметрами
     */

    if ($url === '{offer}') {
        $query_string = http_build_query($parameters);

        $result_url = $url . '&' . $query_string;
    } else {
        $parts_url = parse_url($url);
        parse_str($parts_url['query'], $parts_query);

        foreach ($parameters as $parameter_name => $parameter_value) {
            $parts_query[$parameter_name] = $parameter_value;
        }

        $parts_url['query'] = http_build_query($parts_query);

        $result_url = unparse_url($parts_url);
    }
    return $result_url;
}

function unparse_url($parsed_url)
{
    $scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
    $host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
    $port = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
    $user = isset($parsed_url['user']) ? $parsed_url['user'] : '';
    $pass = isset($parsed_url['pass']) ? ':' . $parsed_url['pass'] : '';
    $pass = ($user || $pass) ? "$pass@" : '';
    $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
    $query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
    $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
    return "$scheme$user$pass$host$port$path$query$fragment";
}

function curl_get_contents($url, $post = null, $head=0){

    $isCurlEnabled = function(){
        return function_exists('curl_version');
    };
    if (!$isCurlEnabled) {
        echo "pls install curl";
        die;
    }

    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    if($head){
        curl_setopt($ch,CURLOPT_HTTPHEADER, $head);
    }else{
        curl_setopt($ch,CURLOPT_HEADER, 0);
    }

    if($post){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function showForm($width, $height, $args = [])
{
    /**
     * Функция создает HTML-разметку с формой заказа
     *
     * @param $width string ширина формы
     * @param $height string высота формы
     * @param $args array параметры формы
     * @return string HTML-разметка
     *
     * В массив $args можно передавать следующие параметры:
     *  language - язык на котором будет отбражаться форма: двузбуквенный код языка ISO 639-1
     *  select - оставить или скрыть выбор страны: 'countrySelect' или 'CountryDefault'
     *  is_price - чтобы скрыть цену передать значение 'no'
     *  color - доступные цвета: light, orange, blue, green, gray, dark
     *
     * Примеры вызова функции:
     *
     * showForm('80%', '600px', ['color' => 'blue', 'language' => 'el', 'is_price' => 'no']);
     * showForm(600px, '600px', ['color' => 'green', 'language' => 'ru', 'select' => 'countrySelect']);
     */

    global $dir_name, $language, $oldPriceHtml, $newPriceHtml, $currencyDisplayHtml;

    if (isset($args['language'])) {
        $language = $args['language'];
    }


    $file_translate = LANDING_DIR . 'invoice2/languages/' . $language . '.php';

    if (!file_exists($file_translate)) {
        $file_translate = 'invoice2/languages/ru.php';
    }
    require($file_translate);


    $hide_price = isset($args['is_price']) && $args['is_price'] == 'no';
    $showCountry = (isset($args['select']) && $args['select'] == 'countrySelect') ? 'countrySelect' : 'countryDefault';


    $unique_postfix = uniqid('__');
    $css_classes = ["form_root", "app", "old_price", "new_price", "fieldset-row-list", "row", "wrapper-form", "order_form"];
    $css_uniq_classes = [];
    foreach ($css_classes as $class_name) {
        $css_uniq_classes[$class_name] = $class_name . $unique_postfix;
    }


    $colors_schemes = [
        'light' => ['background' => '#CC1414', 'background:hover' => '#FA0505'],
        'orange' => ['background' => 'orange', 'background:hover' => '#e7a553'],
        'blue' => ['background' => '#037fec', 'background:hover' => '#318aef'],
        'gray' => ['background' => 'gray', 'background:hover' => '#9f9f9f'],
        'green' => ['background' => '#00a000', 'background:hover' => '#00b800'],
        'dark' => ['background' => '#CC1414', 'background:hover' => '#FA0505'],
    ];
    $color = array_key_exists($args['color'], $colors_schemes) ? $args['color'] : 'light';


    ob_start();

    require_once('form_style.tpl.php');
    require_once('form.tpl.php');

    return ob_get_clean();
}