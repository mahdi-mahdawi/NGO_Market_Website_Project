<?php

function show_ajax_error($http_code = '404', $message = NULL) {
    $message = ($message) ? $message : lang('error_message');

    $CI = & get_instance();
    $CI->output->set_status_header($http_code, $message);
    exit();
}

function set_ajax_flashdata($type = 'success', $message = '') {
    $CI = & get_instance();

    if ($type == 'success') {
        $CI->output->set_status_header('200');
        die(json_encode(array('status' => 1, 'message' => $message)));
    } else {
        $CI->output->set_status_header('404');
        die(json_encode(array('status' => 0, 'message' => $message)));
    }
}

function get_row_status($status) {
    if ($status) {
        return '<span class="label label-success">Active</span>';
    } else {
        return'<span class="label label-danger">Inactive</span>';
    }
}

function get_thumb_dimension($type) {
    switch ($type) {
        case 'cuisine' :
            return array('width' => '400', 'height' => '300');
            break;
        case 'category' :
            return array('width' => '400', 'height' => '300');
            break;
        case 'product' :
            return array('width' => '400', 'height' => '300');
            break;
        case 'blog' :
            return array('width' => '400', 'height' => '300');
            break;
        case 'cover' :
            return array('width' => '400', 'height' => '300');
            break;
        case 'favicon' :
            return array('width' => '250', 'height' => '150');
            break;
        case 'page' :
            return array('width' => '400', 'height' => '300');
            break;

        default :
            return array('width' => NULL, 'height' => NULL);
            break;
    }
}

//format product
function format_product($product = array()) {
    $result_array = array();
    foreach ($product as $row):
        $result_array['product_id'] = $row['product_id'];
        $result_array['product_category_id'] = $row['product_category_id'];
        $result_array['name'] = $row['name'];
        $result_array['description'] = $row['description'];
        $result_array['price'] = $row['price'];
        $result_array['image'] = $row['image'];
        $result_array['status'] = $row['status'];
        $result_array['product_type'][$row['product_type_id']] = $row['product_type_id'];

    endforeach;
    return $result_array;
}

// Generate tree structure of the admin/owner menus - menu reordering
function fetchAllMenus($Menus, $acess_menu_edit, $acess_menu_delete) {
    $mainmenu = "<ol class='dd-list' >";

    foreach ($Menus as $menu) {
        if ($acess_menu_edit) {
            $editBtn = '<a href="#nop" class="pull-right btn-edit-menu" style="margin-left:10px;" data-href="' . base_url('admin/cms/menu/load_edit_form/' . $menu['menu_id']) . '" data-id="' . $menu['menu_id'] . '">Edit</a>';
        } else {
            $editBtn = '';
        }
        if ($acess_menu_delete) {
            $deleteBtn = '<a href="' . base_url('/cms/menu/delete/' . $menu['menu_id']) . '" class="pull-right btn-delete" data-href="/cms/menu/delete/' . $menu['menu_id'] . '">Delete</a>';
        } else {
            $deleteBtn = '';
        }
        $mainmenu.="<li class='dd-item dd3-item' data-id='" . $menu['menu_id'] . "'>" . "<div class='dd-handle dd3-handle'></div><div class='dd3-content'>" . $menu['name'] . $editBtn . "   " . $deleteBtn . "</div>";
        if (is_array($menu['subMenu']))
            $mainmenu.=fetchAllMenus($menu['subMenu'], $acess_menu_edit, $acess_menu_delete);
        $mainmenu.="</li>";
    }
    $mainmenu.="</ol>";
    return $mainmenu;
}

function format_modules($module_details) {
    $return_array = array();
    $i = 0;
    foreach ($module_details as $key => $value) {
        $return_array[$value['module_id']]['title'] = $value['module_name'];
        $return_array[$value['module_id']]['id'] = $value['module_id'];
        $return_array[$value['module_id']]['catId'] = $value['parent_id'];
        $return_array[$value['module_id']]['isFolder'] = true;

        $return_array[$value['module_id']]['children'][$value['access_id']]['title'] = $value['access_name'];
        $return_array[$value['module_id']]['children'][$value['access_id']]['id'] = $value['access_id'];

        $i = $i++;
    }

    return $return_array;
}

function format_permissions($permissions, $group_id) {
    $return_array = array();
    foreach ($permissions as $key => $row) {

        $module_id = $row['key'];
        if ($row['isFolder'] == "true" && isset($row['children'])) {
            foreach ($row['children'] as $value) {
                if ($value['isFolder'] == "true" && isset($value['children'])) {
                    $module_id = $value['key'];
                    foreach ($value['children'] as $child) {
                        if ($child['select'] == "true") {
                            array_push($return_array, array('module_id' => $module_id, 'access_id' => $child['key'], 'group_id' => $group_id));
                        }
                    }
                } else {
                    if ($value['select'] == "true") {
                        array_push($return_array, array('module_id' => $module_id, 'access_id' => $value['key'], 'group_id' => $group_id));
                    }
                }
            }
        }
    }
    return $return_array;
}

if (!function_exists('show_permission_tree')) {

    function show_permission_tree($data, $userPermissions) {
        $html = "";
        if (isset($data) > 0) {
            foreach ($data as $val => $element) {
                $folder = "";
                if (isset($element['children']) && !empty($element['children'])) {
                    $folder = "folder ";
                    $html .= "<li class='expanded " . $folder . "' id='" . $element['id'] . "'>";
                    $html.= $element['title'];
                }
                if (isset($element['children'])) {
                    $html .= "<ul>";
                }
                if (isset($element['children'])) {
                    $html.=show_permission_tree($element['children'], $userPermissions);
                }
                if (count($element) > 0 && !isset($element['children'])) {
                    $selected = (in_array($element['id'], $userPermissions)) ? 'selected' : '';
                    $html .= "<li class='" . $selected . "' id='" . $element['id'] . "'>";
                    $html.= $element['title'];
                    $html .= "</li>";
                }
                if (isset($element['children']))
                    $html .= "</ul>";
                $html .= "</li>";
            }
        }

        return $html;
    }
}

    function format_zip($data = array()) {
        $return_array = array();
        foreach ($data as $row):
            $return_array[$row['city_name']][$row['zip_id']]['city_id'] = $row['city_id'];
            $return_array[$row['city_name']][$row['zip_id']]['zip_id'] = $row['zip_id'];
            $return_array[$row['city_name']][$row['zip_id']]['zipcode'] = $row['zipcode'];
            $return_array[$row['city_name']][$row['zip_id']]['area_name'] = $row['area_name'];
            $return_array[$row['city_name']][$row['zip_id']]['delivery_charge'] = $row['delivery_charge'];
            $return_array[$row['city_name']][$row['zip_id']]['minimum_delivery_amount'] = $row['minimum_delivery_amount'];
            $return_array[$row['city_name']][$row['zip_id']]['[delivery_time'] = $row['delivery_time'];
            $return_array[$row['city_name']][$row['zip_id']]['status'] = $row['status'];
            $return_array[$row['city_name']][$row['zip_id']]['date_created'] = $row['date_created'];
        endforeach;
        return $return_array;
    }
if (!function_exists('transformProductModifiers')) {

    /**
     * Transform product modifiers.
     * 
     * @param array $items
     *
     * @return JSON
     */
    function transformProductModifiers($items)
    {
        if(empty($items)){
            return [];
        }
        
        $modifierId = null;

        foreach($items as $item) {
            if($modifierId != $item->modifier_id) {
                $modifierId = $item->modifier_id;

                $result[$modifierId] = [
                    'id' => $item->modifier_id,
                    'name' => $item->name,
                    'minimum' => $item->minimum,
                    'maximum' => $item->maximum,
                    'items' => []
                ];
            }

            $result[$modifierId]['items'][$item->item_id] = [
                'id' => $item->item_id,
                'name' => $item->item_name,
                'price' => $item->item_price
            ];
        }

        return $result;
    }
}

function transformOrderProducts($products = []) 
{
        if(empty($products)) {
            return FALSE;
        }

        $orderProductId = null;

        foreach($products as $row) 
        {
            if($orderProductId != $row['order_item_id'])
            {
                $orderProductId = $row['order_item_id'];

                $result[$orderProductId] = [
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'quantity' => $row['quantity'],
                    'subtotal' =>$row['subtotal']
                ];
            }

            if(isset($row['modifier_item_id'])) {
                $result[$orderProductId]['options'][$row['modifier_item_id']] = [
                    'id' => $row['modifier_item_id'],
                    'name' => $row['modifier_item_name'],
                    'price' => $row['modifier_item_price'],
                    'modifier_id' => $row['modifier_id']
                ];
            }
        }

        return $result;
}

function get_timezones() {
    return [
          '(GMT-12:00) International Date Line West' => 'Pacific/Wake',
          '(GMT-11:00) Midway Island' => 'Pacific/Apia',
          '(GMT-11:00) Samoa' => 'Pacific/Apia',
          '(GMT-10:00) Hawaii' => 'Pacific/Honolulu',
          '(GMT-09:00) Alaska' => 'America/Anchorage',
          '(GMT-08:00) Pacific Time (US &amp; Canada); Tijuana' => 'America/Los_Angeles',
          '(GMT-07:00) Arizona' => 'America/Phoenix',
          '(GMT-07:00) Chihuahua' => 'America/Chihuahua',
          '(GMT-07:00) La Paz' => 'America/Chihuahua',
          '(GMT-07:00) Mazatlan' => 'America/Chihuahua',
          '(GMT-07:00) Mountain Time (US &amp; Canada)' => 'America/Denver',
          '(GMT-06:00) Central America' => 'America/Managua',
          '(GMT-06:00) Central Time (US &amp; Canada)' => 'America/Chicago',
          '(GMT-06:00) Guadalajara' => 'America/Mexico_City',
          '(GMT-06:00) Mexico City' => 'America/Mexico_City',
          '(GMT-06:00) Monterrey' => 'America/Mexico_City',
          '(GMT-06:00) Saskatchewan' => 'America/Regina',
          '(GMT-05:00) Bogota' => 'America/Bogota',
          '(GMT-05:00) Eastern Time (US &amp; Canada)' => 'America/New_York',
          '(GMT-05:00) Indiana (East)' => 'America/Indiana/Indianapolis',
          '(GMT-05:00) Lima' => 'America/Bogota',
          '(GMT-05:00) Quito' => 'America/Bogota',
          '(GMT-04:00) Atlantic Time (Canada)' => 'America/Halifax',
          '(GMT-04:00) Caracas' => 'America/Caracas',
          '(GMT-04:00) La Paz' => 'America/Caracas',
          '(GMT-04:00) Santiago' => 'America/Santiago',
          '(GMT-03:30) Newfoundland' => 'America/St_Johns',
          '(GMT-03:00) Brasilia' => 'America/Sao_Paulo',
          '(GMT-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
          '(GMT-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
          '(GMT-03:00) Greenland' => 'America/Godthab',
          '(GMT-02:00) Mid-Atlantic' => 'America/Noronha',
          '(GMT-01:00) Azores' => 'Atlantic/Azores',
          '(GMT-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
          '(GMT) Casablanca' => 'Africa/Casablanca',
          '(GMT) Edinburgh' => 'Europe/London',
          '(GMT) Greenwich Mean Time : Dublin' => 'Europe/London',
          '(GMT) Lisbon' => 'Europe/London',
          '(GMT) London' => 'Europe/London',
          '(GMT) Monrovia' => 'Africa/Casablanca',
          '(GMT+01:00) Amsterdam' => 'Europe/Berlin',
          '(GMT+01:00) Belgrade' => 'Europe/Belgrade',
          '(GMT+01:00) Berlin' => 'Europe/Berlin',
          '(GMT+01:00) Bern' => 'Europe/Berlin',
          '(GMT+01:00) Bratislava' => 'Europe/Belgrade',
          '(GMT+01:00) Brussels' => 'Europe/Paris',
          '(GMT+01:00) Budapest' => 'Europe/Belgrade',
          '(GMT+01:00) Copenhagen' => 'Europe/Paris',
          '(GMT+01:00) Ljubljana' => 'Europe/Belgrade',
          '(GMT+01:00) Madrid' => 'Europe/Paris',
          '(GMT+01:00) Paris' => 'Europe/Paris',
          '(GMT+01:00) Prague' => 'Europe/Belgrade',
          '(GMT+01:00) Rome' => 'Europe/Berlin',
          '(GMT+01:00) Sarajevo' => 'Europe/Sarajevo',
          '(GMT+01:00) Skopje' => 'Europe/Sarajevo',
          '(GMT+01:00) Stockholm' => 'Europe/Berlin',
          '(GMT+01:00) Vienna' => 'Europe/Berlin',
          '(GMT+01:00) Warsaw' => 'Europe/Sarajevo',
          '(GMT+01:00) West Central Africa' => 'Africa/Lagos',
          '(GMT+01:00) Zagreb' => 'Europe/Sarajevo',
          '(GMT+02:00) Athens' => 'Europe/Istanbul',
          '(GMT+02:00) Bucharest' => 'Europe/Bucharest',
          '(GMT+02:00) Cairo' => 'Africa/Cairo',
          '(GMT+02:00) Harare' => 'Africa/Johannesburg',
          '(GMT+02:00) Helsinki' => 'Europe/Helsinki',
          '(GMT+02:00) Istanbul' => 'Europe/Istanbul',
          '(GMT+02:00) Jerusalem' => 'Asia/Jerusalem',
          '(GMT+02:00) Kyiv' => 'Europe/Helsinki',
          '(GMT+02:00) Minsk' => 'Europe/Istanbul',
          '(GMT+02:00) Pretoria' => 'Africa/Johannesburg',
          '(GMT+02:00) Riga' => 'Europe/Helsinki',
          '(GMT+02:00) Sofia' => 'Europe/Helsinki',
          '(GMT+02:00) Tallinn' => 'Europe/Helsinki',
          '(GMT+02:00) Vilnius' => 'Europe/Helsinki',
          '(GMT+03:00) Baghdad' => 'Asia/Baghdad',
          '(GMT+03:00) Kuwait' => 'Asia/Riyadh',
          '(GMT+03:00) Moscow' => 'Europe/Moscow',
          '(GMT+03:00) Nairobi' => 'Africa/Nairobi',
          '(GMT+03:00) Riyadh' => 'Asia/Riyadh',
          '(GMT+03:00) St. Petersburg' => 'Europe/Moscow',
          '(GMT+03:00) Volgograd' => 'Europe/Moscow',
          '(GMT+03:30) Tehran' => 'Asia/Tehran',
          '(GMT+04:00) Abu Dhabi' => 'Asia/Muscat',
          '(GMT+04:00) Baku' => 'Asia/Tbilisi',
          '(GMT+04:00) Muscat' => 'Asia/Muscat',
          '(GMT+04:00) Tbilisi' => 'Asia/Tbilisi',
          '(GMT+04:00) Yerevan' => 'Asia/Tbilisi',
          '(GMT+04:30) Kabul' => 'Asia/Kabul',
          '(GMT+05:00) Ekaterinburg' => 'Asia/Yekaterinburg',
          '(GMT+05:00) Islamabad' => 'Asia/Karachi',
          '(GMT+05:00) Karachi' => 'Asia/Karachi',
          '(GMT+05:00) Tashkent' => 'Asia/Karachi',
          '(GMT+05:30) Chennai' => 'Asia/Calcutta',
          '(GMT+05:30) Kolkata' => 'Asia/Calcutta',
          '(GMT+05:30) Mumbai' => 'Asia/Calcutta',
          '(GMT+05:30) New Delhi' => 'Asia/Calcutta',
          '(GMT+05:45) Kathmandu' => 'Asia/Katmandu',
          '(GMT+06:00) Almaty' => 'Asia/Novosibirsk',
          '(GMT+06:00) Astana' => 'Asia/Dhaka',
          '(GMT+06:00) Dhaka' => 'Asia/Dhaka',
          '(GMT+06:00) Novosibirsk' => 'Asia/Novosibirsk',
          '(GMT+06:00) Sri Jayawardenepura' => 'Asia/Colombo',
          '(GMT+06:30) Rangoon' => 'Asia/Rangoon',
          '(GMT+07:00) Bangkok' => 'Asia/Bangkok',
          '(GMT+07:00) Hanoi' => 'Asia/Bangkok',
          '(GMT+07:00) Jakarta' => 'Asia/Bangkok',
          '(GMT+07:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
          '(GMT+08:00) Beijing' => 'Asia/Hong_Kong',
          '(GMT+08:00) Chongqing' => 'Asia/Hong_Kong',
          '(GMT+08:00) Hong Kong' => 'Asia/Hong_Kong',
          '(GMT+08:00) Irkutsk' => 'Asia/Irkutsk',
          '(GMT+08:00) Kuala Lumpur' => 'Asia/Singapore',
          '(GMT+08:00) Perth' => 'Australia/Perth',
          '(GMT+08:00) Singapore' => 'Asia/Singapore',
          '(GMT+08:00) Taipei' => 'Asia/Taipei',
          '(GMT+08:00) Ulaan Bataar' => 'Asia/Irkutsk',
          '(GMT+08:00) Urumqi' => 'Asia/Hong_Kong',
          '(GMT+09:00) Osaka' => 'Asia/Tokyo',
          '(GMT+09:00) Sapporo' => 'Asia/Tokyo',
          '(GMT+09:00) Seoul' => 'Asia/Seoul',
          '(GMT+09:00) Tokyo' => 'Asia/Tokyo',
          '(GMT+09:00) Yakutsk' => 'Asia/Yakutsk',
          '(GMT+09:30) Adelaide' => 'Australia/Adelaide',
          '(GMT+09:30) Darwin' => 'Australia/Darwin',
          '(GMT+10:00) Brisbane' => 'Australia/Brisbane',
          '(GMT+10:00) Canberra' => 'Australia/Sydney',
          '(GMT+10:00) Guam' => 'Pacific/Guam',
          '(GMT+10:00) Hobart' => 'Australia/Hobart',
          '(GMT+10:00) Melbourne' => 'Australia/Sydney',
          '(GMT+10:00) Port Moresby' => 'Pacific/Guam',
          '(GMT+10:00) Sydney' => 'Australia/Sydney',
          '(GMT+10:00) Vladivostok' => 'Asia/Vladivostok',
          '(GMT+11:00) Magadan' => 'Asia/Magadan',
          '(GMT+11:00) New Caledonia' => 'Asia/Magadan',
          '(GMT+11:00) Solomon Is.' => 'Asia/Magadan',
          '(GMT+12:00) Auckland' => 'Pacific/Auckland',
          '(GMT+12:00) Fiji' => 'Pacific/Fiji',
          '(GMT+12:00) Kamchatka' => 'Pacific/Fiji',
          '(GMT+12:00) Marshall Is.' => 'Pacific/Fiji',
          '(GMT+12:00) Wellington' => 'Pacific/Auckland',
          '(GMT+13:00) Nuku\'alofa' => 'Pacific/Tongatapu',
    ];
}