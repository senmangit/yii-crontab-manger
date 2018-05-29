<?php

namespace Crontab\models;

/**
 * This is the model class for table "{{%cron_log}}".
 *
 * @property integer $id
 * @property integer $cron_config_id
 * @property integer $status
 * @property string $remark
 * @property string $create_time
 *
 * @property CronConfig $cronConfig
 */
class CronLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cron_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cron_config_id', 'status'], 'required'],
            [['cron_config_id', 'status'], 'integer'],
            [['create_time'], 'safe'],
            [['remark'], 'string', 'max' => 555],
            [['cron_config_id'], 'exist', 'skipOnError' => true, 'targetClass' => CronConfig::className(), 'targetAttribute' => ['cron_config_id' => 'cron_config_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cron_config_id' => 'Cron Config ID',
            'status' => 'Status',
            'remark' => 'Remark',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCronConfig()
    {
        return $this->hasOne(CronConfig::className(), ['cron_config_id' => 'cron_config_id']);
    }

    /**
     * @param $id
     * @param string $fields
     * @return mixed
     */

    public static function getCronLogById($id, $fields = "*")
    {
        return CronLog::find()->select($fields)->where(["id" => $id])->one();
    }

    public static function add($data)
    {
        $model = new CronLog();
        $model->load($data, CronLog::className());
        return $model->save();
    }
}
