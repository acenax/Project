<?php
class ThaiDatetime
{
    protected static $short_months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    protected static $long_months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤกษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    public function __construct()
    {
    }
    public static function to_human_date(string $datetime, string $format = 'short')
    {
        if (empty($datetime)) {
            return $datetime;
        }

        if ('short' == $format) {
            return self::to_short_date($datetime);
        }

        return self::to_long_date($datetime);
    }

    public static function to_short_date(string $datetime)
    {
        if (empty($datetime)) {
            return $datetime;
        }

        $arr = explode('-', date('Y-n-d', strtotime($datetime)));
        $arr[0] += 543;

        return sprintf('%02s %s %02s', $arr[2], self::$short_months[$arr[1]], $arr[0] % 100);
    }

    public static function to_long_date(string $datetime)
    {
        if (empty($datetime)) {
            return $datetime;
        }

        $arr = explode('-', date('Y-n-d', strtotime($datetime)));
        $arr[0] += 543;

        return sprintf('%02s %s %04s', $arr[2], self::$long_months[$arr[1]], $arr[0]);
    }
}
