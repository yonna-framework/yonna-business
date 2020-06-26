<?php

namespace Yonna\QuickStart\Scope\User;

use App\Helper\Password;
use QuickStart\Mapping\Common\Boolean;
use QuickStart\Mapping\User\AccountType;
use QuickStart\Mapping\User\UserStatus;
use Throwable;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Log\Log;
use Yonna\QuickStart\Scope\AbstractScope;
use Yonna\Throwable\Exception;

/**
 * Class Sign
 * @package App\Log\User
 */
class Sign extends AbstractScope
{

    const ONLINE_KEEP_TIME = 86400;
    const ONLINE_REDIS_KEY = 'user:online:';

    /**
     * 登录记录
     * @param $userInfo
     * @return bool
     * @throws Exception\DatabaseException
     * @throws Exception\ParamsException
     */
    private function loginRecord($userInfo)
    {
        if (!$userInfo['user_uid']) {
            Exception::params('登录记录参数不全');
        }
        // 写日志
        $input = $this->input();
        $input['password'] = '*';
        $log = [
            'uid' => $userInfo['user_uid'],
            'ip' => $this->request()->getIp(),
            'client_id' => $this->request()->getClientId(),
            'input' => $input,
        ];
        Log::db()->info($log, 'login');
        // 设定uid为登录状态
        $onlineKey = self::ONLINE_REDIS_KEY . $log['uid'];
        if (DB::redis()->get($onlineKey) === 'online') {
            DB::redis()->expire($onlineKey, self::ONLINE_KEEP_TIME);
        } else {
            DB::redis()->set($onlineKey, 'online', self::ONLINE_KEEP_TIME);
        }
        return true;
    }

    /**
     * @return bool
     * @throws null
     */
    public function isLogin()
    {
        $onlineKey = self::ONLINE_REDIS_KEY . $this->input('auth_uid');
        $res = DB::redis()->get($onlineKey) ?? null;
        return $res === 'online';
    }

    /**
     * logout
     * @return mixed
     * @throws Throwable
     */
    public function out()
    {
        $onlineKey = self::ONLINE_REDIS_KEY . $this->input('auth_uid');
        DB::redis()->delete($onlineKey);
        return true;
    }

    /**
     * @return mixed
     * @throws Throwable
     */
    public function in()
    {
        $account = $this->input('account');
        $password = $this->input('password');
        if (!$account) {
            Exception::params("error account");
        }
        if (!$password) {
            Exception::params("error password");
        }
        // 看看账号是否存在
        $accounts = DB::connect()
            ->table('user_account')
            ->field('uid')
            ->where(function (Where $cond) use ($account) {
                $cond->in('type', [AccountType::NAME, AccountType::PHONE, AccountType::EMAIL])
                    ->equalTo('string', $account)
                    ->equalTo('allow_login', Boolean::true);
            })
            ->one();
        if (empty($accounts['user_account_id'])) {
            Exception::params("Account does not exist");
        }
        $user_id = $accounts['user_account_id'];
        $userInfo = DB::connect()
            ->table('user')
            ->field('uid,status,password')
            ->where(fn(Where $w) => $w->equalTo('id', $user_id))
            ->one();
        // 检查账号状态
        switch ($userInfo['user_status']) {
            case UserStatus::DELETE:
                Exception::permission('Account is not exist');
                break;
            case UserStatus::FREEZE:
                Exception::throw('Account has been frozen');
                break;
            case UserStatus::PENDING:
                Exception::throw('Account has not been approved, please wait for approval');
                break;
            case UserStatus::REJECTION:
                Exception::throw('Account audit failed');
                break;
            default:
                break;
        }
        // 检查许可
        $userLicense = DB::connect()
            ->table('user_license')
            ->field('license_id')
            ->equalTo('uid', $uid)
            ->lessThanOrEqualTo('start_time', date('Y-m-d H:i:s', time()))
            ->greaterThanOrEqualTo('end_time', date('Y-m-d H:i:s', time()))
            ->multi();
        if (!$userLicense) {
            Exception::throw("Account not any licensed");
        }
        $userLicenseIds = array_column($userLicense, 'user_license_license_id');
        if (in_array(1, $userLicenseIds)) {
            //super account
        } else {
            Exception::throw("Account not licensed");
        }
        // 检查密码
        if (empty($userInfo['user_password']) || $userInfo['user_password'] !== Password::parse($password)) {
            Exception::throw('Wrong password');
        }
        // 记录登录信息
        try {
            $this->loginRecord($userInfo);
        } catch (Throwable $e) {
            Exception::origin($e);
        }
        return [
            'user_id' => $uid,
            'user_account' => $account,
            'user_status' => $userInfo['user_status'],
        ];
    }

}