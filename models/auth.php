<?

class auth extends base {
    protected static $table = 'authentication';

    public static function is_authorized ($token) {
        return (bool)self::get_user_id($token);
    }

    public static function get_user_id ($token) {
        return App::$db->getOne(
            'SELECT user_id FROM ' . self::$table . ' WHERE token = :token LIMIT 1',
            [':token' => $token]
        )['user_id'];
    }

    public static function authorize ($id)
    {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $data = [
            'user_id' => $id,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ];
        self::save($data, self::$table);
        return $token;
    }

    public static function signOut ($token) {
        return App::$db->exec('DELETE FROM ' . self::$table . ' WHERE token = :token', [':token' => $token]);
    }
}