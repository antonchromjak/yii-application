<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property int $id
 * @property string $title
 * @property string|null $perex
 * @property string|null $content
 * @property string $publishedAt
 * @property int|null $userId
 *
 * @property User $user
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @var \yii\web\UploadedFile
     */
    public $photoFile;
    public $photo;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['perex', 'content'], 'string'],
            [['publishedAt'], 'safe'],
            [['userId'], 'integer'],
            [['title', 'tags'], 'string', 'max' => 512],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'perex' => 'Perex',
            'content' => 'Content',
            'publishedAt' => 'Published At',
            'userId' => 'User ID',
            'tags' => 'Tags',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PostQuery(get_called_class());
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $isInsert = $this->isNewRecord;
        if($isInsert){
            //$this->photo = $this->photoFile->name;
        }
        $saved = parent::save($runValidation, $attributeNames);
        if(!$saved){
            return false;
        }
        if($isInsert){
            $photoPath = Yii::getAlias('@frontend/web/storage/photos/' 
            . $this->id .'.'. pathinfo($this->photoFile->name, PATHINFO_EXTENSION));
            if(!is_dir(dirname($photoPath))){
                FileHelper::createDirectory(dirname($photoPath));
            }
            if($this->photoFile)
                $this->photoFile->saveAs($photoPath);
        }
        return true;
    }
    public function afterDelete(){
        parent::afterDelete();
        $photoPath = Yii::getAlias('@frontend/web/storage/photos/' . $this->id .'.jpg');
        if(file_exists($photoPath))
            unlink($photoPath);
    }
}
