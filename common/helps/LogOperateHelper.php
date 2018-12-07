<?php

namespace common\helps;

use common\models\LogOperate;
use yii\base\Exception;

class LogOperateHelper
{
    /**
     * 日志插入
     * @param int $category_id
     * @param int $primary_id
     * @param string $desc
     * @throws \yii\base\Exception
     */
    public static function insert($category_id = 0, $primary_id = 0, $desc = '') {
        $user = \Yii::$app->user->identity;
        if (empty($user) || empty($category_id) || empty($primary_id) || empty($desc)) {
            throw new Exception("日志插入必要参数不能为空！");
        }
        $query = new LogOperate();
        $query->category_id = $category_id;
        $query->admin_username = $user->username;
        $query->desc = $desc;
        $query->primary_id = $primary_id;
        $query->ip = \Yii::$app->request->userIP;
        $query->save();
    }

    /**
     * 日志查询
     * @param int $category_id
     * @param int $primary_id
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\base\Exception
     */
    public static function get($category_id = 0, $primary_id = 0) {
        if (empty($category_id) || empty($primary_id)) {
            throw new Exception("日志查询参数不能为空！");
        }
        $data = LogOperate::find()->where(['category_id' => $category_id, 'primary_id' => $primary_id])->asArray()->all();
        return $data;
    }

    /**
     * 日志模板渲染查看
     * @param int $category_id
     * @param int $primary_id
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\base\Exception
     */
    public static function render($category_id = 0, $primary_id = 0) {
        if (empty($category_id) || empty($primary_id)) {
            throw new Exception("日志查询参数不能为空！");
        }
        $data = LogOperate::find()->where(['category_id' => $category_id, 'primary_id' => $primary_id])->orderBy(['created_at' => SORT_DESC])->asArray()->all();
        if (empty($data)) {
            return "<span style='font-size: 12px;'>不存在操作日志</span>";
        } else {

            $content = "<table style='width: 100%; margin: 0 auto; text-align: center;'>
                <tr style='background-color: #cecdcd; color: #444; font-size: 14px; height: 30px; '>
                    <td style='width: 25%;'>操作时间</td>
                    <td style='width: 25%;'>操作人员</td>
                    <td style='width: 25%;'>IP地址</td>
                    <td style='width: 25%;'>描述</td>
                </tr>
            ";
            foreach ($data as $k => $v) {
                $v['created_at'] = date("Y-m-d H:i:s",  $v['created_at']);
                $content .= "<tr style='border-bottom: 1px solid #626262;'>
                    <td style='height: 40px;'>{$v['created_at']}</td>
                    <td style='height: 40px;'>{$v['admin_username']}</td>
                    <td style='height: 40px;'>{$v['ip']}</td>
                    <td style='height: 40px;'>{$v['desc']}</td>
                </tr>";
            }
            $content .= "</table>";
            return $content;
        }
    }
}