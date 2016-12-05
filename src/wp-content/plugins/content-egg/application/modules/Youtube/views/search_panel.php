<select ng-model="query_params.<?php echo $module_id; ?>.license">
    <option value="any"><?php _e('Любая лицензия', 'content-egg'); ?></option>
    <option value="creativeCommon"><?php _e('Сreative Сommons', 'content-egg'); ?></option>
    <option value="youtube"><?php _e('Стандартная лицензия', 'content-egg'); ?></option>
</select>

<select ng-model="query_params.<?php echo $module_id; ?>.order">
    <option value="date"><?php _e('Дата', 'content-egg'); ?></option>
    <option value="rating"><?php _e('Рейтинг', 'content-egg'); ?></option>
    <option value="relevance"><?php _e('Релевантность', 'content-egg'); ?></option>
    <option value="title"><?php _e('Заголовок', 'content-egg'); ?></option>
    <option value="viewCount"><?php _e('Просмотры', 'content-egg'); ?></option>
</select>