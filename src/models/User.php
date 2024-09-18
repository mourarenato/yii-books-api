<?php

namespace app\models;

use app\repositories\RefreshTokenRepository;
use app\services\JwtAuthService;
use app\services\RefreshTokenService;
use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property int $password
 * @property int $authKey
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName(): string
    {
        return 'user';
    }

    public function rules(): array
    {
        return [
            [['username', 'password', 'name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            ['username', 'unique'],
            ['password', 'string', 'min' => 6],
            ['name', 'string', 'min' => 3, 'max' => 255],
            ['authKey', 'string'],
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => function () {
                    return time(); // Or `date('Y-m-d H:i:s')` for datetime
                },
            ],
        ];
    }

    /**
     * @throws Exception
     */
    public function beforeSave($insert): bool
    {
        if ($this->isAttributeChanged('password')) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }

        return parent::beforeSave($insert);
    }

    public static function findIdentity($id): ?IdentityInterface
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        $refreshTokenService = new RefreshTokenService(
            new RefreshTokenRepository()
        );
        $jwtAuth = new JwtAuthService($refreshTokenService);
        $decoded = $jwtAuth->validateToken($token);

        if ($decoded && isset($decoded['uid'])) {
            return self::findOne($decoded['uid']);
        }

        return null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthKey(): ?string
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getModelName(): string //for test
    {
        return 'User';
    }
}
