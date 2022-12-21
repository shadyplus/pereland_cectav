<?php
global $companyInfo, $landings_default_domain, $default_main_site;
global $prepaid_info_html;
$doclinks = isset($doclinks) ? $doclinks : true;
$pplink = isset($pplink) ? $pplink : true;
if (array_key_exists('pplink', $_GET) && $_GET['pplink'] == '0') {
    $pplink = false;
}
$linksPosition = isset($linksPosition) ? $linksPosition : 'column';
$policy = isset($policy) ? $policy : true;

$company_detail = isset($companyInfo['detail']) ? $companyInfo['detail'] : 'ТОО "АЛЬФА-ТРЕЙД ГРУПП" &nbsp; РНН: 481400103249 &nbsp; БИН: 201040024497';
$company_address = isset($companyInfo['address']) ? $companyInfo['address'] : 'Казахстан, Северо-Казахстанская область, ПЕТРОПАВЛОВСК Г.А., Г.ПЕТРОПАВЛОВСК, УЛИЦА СОВЕТСКАЯ, 33';
?>
<p><?= $company_detail ?></p>
<p><?= $company_address ?></p>
<p>email: trade@mail.ru</p>
<p>Skype: trade2022</p>

<?php if ($linksPosition == 'line'): ?>

    <p class="tlight-link">
        <?php if ($prepaid_info_html && !empty($prepaid_info_html)): ?>
            <a href="//z246.ru/" target="_blank">Предоплата заказа</a>
        <?php endif ?>

        <?php if ($doclinks): ?>
            <a class="nav-link" href="" onclick="window.open('/policykz.php'); return false;">Политика
                конфиденциальности</a>
            <a class="nav-link"  href="" onclick="window.open('/policykz2.php'); return false;">
                Политика обмена и возврата товара
            </a>
        <?php endif ?>
    </p>

<?php else: ?>

    <?php if ($prepaid_info_html && !empty($prepaid_info_html)): ?>
        <p class="tlight-link">
            <a href="//z246.ru/" target="_blank">Предоплата заказа</a>
        </p>
    <?php endif ?>

    <?php if ($doclinks): ?>

        <?php if ($policy): ?>
            <p class="conf-link doclinks">
                <a class="nav-link" href="" onclick="window.open('/policykz.php'); return false;">Политика
                    конфиденциальности </a>
            </p>
            <p class="policy-link doclinks">
                <a class="nav-link"  href="" onclick="window.open('/policykz2.php'); return false;">
                    Политика обмена и возврата товара
                </a>
            </p>
        <?php endif ?>

    <?php endif ?>

<?php endif ?>
