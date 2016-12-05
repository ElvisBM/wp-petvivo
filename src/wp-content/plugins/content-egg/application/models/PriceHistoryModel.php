<?php

namespace ContentEgg\application\models;

use ContentEgg\application\admin\GeneralConfig;

/**
 * PriceHistoryModel class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2016 keywordrush.com
 */
class PriceHistoryModel extends Model {

    public function tableName()
    {
        return $this->getDb()->prefix . 'cegg_price_history';
    }

    public function getDump()
    {

        return "CREATE TABLE " . $this->tableName() . " (
                    unique_id varchar(255) NOT NULL,
                    module_id varchar(255) NOT NULL,
                    create_date datetime NOT NULL,
                    price float(9,2) NOT NULL,                    
                    post_id bigint(20) unsigned DEFAULT NULL,
                    KEY uid (unique_id(80),module_id(30)),
                    KEY create_date (create_date)
                    ) $this->charset_collate;";
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function save(array $item)
    {
        if (empty($item['create_date']))
            $item['create_date'] = current_time('mysql');
        $this->getDb()->insert($this->tableName(), $item);
        return true;
    }

    public function getLastPriceValue($unique_id, $module_id, $offset = null)
    {
        $params = array(
            'select' => 'price',
            'where' => array('unique_id = %s AND module_id = %s', array($unique_id, $module_id)),
            'order' => 'create_date DESC',
            'limit' => 1
        );
        if ($offset)
            $params['offset'] = $offset;
        $row = $this->find($params);
        if (!$row)
            return null;
        return $row['price'];
    }

    public function getPreviousPriceValue($unique_id, $module_id)
    {
        return $this->getLastPriceValue($unique_id, $module_id, 1);
    }

    public function getFirstDateValue($unique_id, $module_id)
    {
        $params = array(
            'select' => 'create_date',
            'where' => array('unique_id = %s AND module_id = %s', array($unique_id, $module_id)),
            'order' => 'create_date ASC',
            'limit' => 1
        );
        $row = $this->find($params);
        if (!$row)
            return null;
        return $row['create_date'];
    }

    public function getLastPrices($unique_id, $module_id, $limit = 5)
    {
        $params = array(
            'where' => array('unique_id = %s AND module_id = %s', array($unique_id, $module_id)),
            'order' => 'create_date DESC',
            'limit' => $limit,
        );
        return $this->findAll($params);
    }

    public function getMaxPrice($unique_id, $module_id)
    {
        $where = $this->prepareWhere((array('unique_id = %s AND module_id = %s', array($unique_id, $module_id))));
        $sql = 'SELECT t.* FROM ' . $this->tableName() . ' t';
        $sql .= ' JOIN (SELECT unique_id, MAX(price) maxPrice FROM ' . $this->tableName() . $where . ') t2 ON t.price = t2.maxPrice AND t.unique_id = t2.unique_id;';
        return $this->getDb()->get_row($sql, \ARRAY_A);
    }

    public function getMinPrice($unique_id, $module_id)
    {
        $where = $this->prepareWhere((array('unique_id = %s AND module_id = %s', array($unique_id, $module_id))));
        $sql = 'SELECT t.* FROM ' . $this->tableName() . ' t';
        $sql .= ' JOIN (SELECT unique_id, MIN(price) minPrice FROM ' . $this->tableName() . $where . ') t2 ON t.price = t2.minPrice AND t.unique_id = t2.unique_id;';
        return $this->getDb()->get_row($sql, \ARRAY_A);
    }

    public function saveData(array $data, $module_id, $post_id = null)
    {
        if (!$post_id)
        {
            global $post;
            if (!empty($post))
                $post_id = $post->ID;
        }
        $saved = 0;
        foreach ($data as $key => $d)
        {
            if (empty($d['unique_id']) || empty($d['price']))
                continue;

            $latest_price = $this->getLastPriceValue($d['unique_id'], $module_id);

            // price changed?
            if ($latest_price && (float) $latest_price == (float) $d['price'])
                continue;

            $save = array(
                'unique_id' => $d['unique_id'],
                'module_id' => $module_id,
                'price' => $d['price'],
                'post_id' => $post_id,
            );
            $this->save($save);
            $saved++;
        }

        // clean up & optimize
        if ($saved && rand(1, 10) == 10)
        {
            $this->cleanOld((int) GeneralConfig::getInstance()->option('price_history_days'));
        }
    }

}
