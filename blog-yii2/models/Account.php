<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User Account Model
 *
 * This model represents user accounts in the blog system.
 * Implements IdentityInterface for Yii2 authentication.
 *
 * @property string $username User's unique username (primary key)
 * @property string $password User's hashed password
 * @property string $name User's full name
 * @property string $role User's role (admin/author)
 *
 * @property Post[] $posts All posts created by this user
 */
class Account extends ActiveRecord implements IdentityInterface
{
    /** @var string Admin role constant */
    const ROLE_ADMIN = 'admin';
    
    /** @var string Author role constant */
    const ROLE_AUTHOR = 'author';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'name', 'role'], 'required'],
            [['username', 'name', 'role'], 'string', 'max' => 45],
            [['password'], 'string', 'max' => 250],
            [['username'], 'unique'],
            [['role'], 'in', 'range' => [self::ROLE_ADMIN, self::ROLE_AUTHOR]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Full Name',
            'role' => 'Role',
        ];
    }

    /**
     * Gets query for related posts.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['username' => 'username']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['username' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is author
     *
     * @return bool
     */
    public function isAuthor()
    {
        return $this->role === self::ROLE_AUTHOR;
    }

    /**
     * Get role options for dropdowns
     *
     * @return array
     */
    public static function getRoleOptions()
    {
        return [
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_AUTHOR => 'Author',
        ];
    }
}