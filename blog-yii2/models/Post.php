<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Blog Post Model
 *
 * This model represents blog posts in the system.
 * Includes automatic timestamp behavior for creation/update tracking.
 *
 * @property int $idpost Post ID (auto-increment primary key)
 * @property string $title Post title
 * @property string $content Post content/body
 * @property string $date Creation/update timestamp
 * @property string $username Author's username (foreign key)
 *
 * @property Account $author Related Account model for the post author
 */
class Post extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date'],
                ],
                'value' => function() {
                    return date('Y-m-d H:i:s');
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'username'], 'required'],
            [['title', 'content'], 'string'],
            [['date'], 'safe'],
            [['username'], 'string', 'max' => 45],
            [['username'], 'exist', 'skipOnError' => true, 'targetClass' => Account::class, 'targetAttribute' => ['username' => 'username']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idpost' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'date' => 'Date',
            'username' => 'Author',
        ];
    }

    /**
     * Gets query for related account (author).
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Account::class, ['username' => 'username']);
    }

    /**
     * Gets the author's full name
     *
     * @return string
     */
    public function getAuthorName()
    {
        return $this->author ? $this->author->name : 'Unknown';
    }

    /**
     * Get formatted date
     *
     * @return string
     */
    public function getFormattedDate()
    {
        return Yii::$app->formatter->asDatetime($this->date);
    }

    /**
     * Get content preview (first 100 characters)
     *
     * @return string
     */
    public function getContentPreview($length = 100)
    {
        return mb_substr(strip_tags($this->content), 0, $length) . (mb_strlen($this->content) > $length ? '...' : '');
    }
}