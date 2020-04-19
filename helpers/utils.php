<?

class utils {
    public static function implode_array_keys ($glue, $array) {
        $array_of_keys = [];
        foreach ($array as $key => $value) {
            $array_of_keys[] = $key;
        }
        return implode($glue, $array_of_keys);
    }

    public static function generate_password ($pwd, $salt='') {
		$hash = hash_hmac('sha256', md5($pwd), $salt);
		return $hash;
    }
    
    public static function get_country_flag_url ($country_code, $size = 32) {
        return 'https://www.countryflags.io/' . $country_code . '/flat/' . $size . '.png';
    }

    public static function convert_to_camel_case ($str, $separator = '-', $prefix = '', $postfix = '') {
        $array_of_str = explode($separator, $str);

        return $prefix . implode('', array_map(function ($value) {
            return ucfirst($value);
        }, $array_of_str)) . $postfix;
    }

    protected static function create_hi_score_verify_token ($score, $auth_token) {
        return md5(md5($score) . md5($auth_token) . $auth_token . md5($auth_token . $score));
    }

    public static function is_hi_score_token_valid ($token, $score, $auth_token) {
        return $token == self::create_hi_score_verify_token($score, $auth_token);
    }
}