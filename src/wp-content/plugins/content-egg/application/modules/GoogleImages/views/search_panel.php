<select ng-model="query_params.<?php echo $module_id; ?>.license">
    <option value=""><?php _e('Любая лицензия', 'content-egg'); ?></option>
    <option value="(cc_publicdomain|cc_attribute|cc_sharealike|cc_noncommercial|cc_nonderived)"><?php _e('Любая Сreative Сommons', 'content-egg'); ?></option>
    <option value="(cc_publicdomain|cc_attribute|cc_sharealike|cc_nonderived).-(cc_noncommercial)"><?php _e('Разрешено коммерческое использование', 'content-egg'); ?></option>
    <option value="(cc_publicdomain|cc_attribute|cc_sharealike|cc_noncommercial).-(cc_nonderived)"><?php _e('Разрешено изменение', 'content-egg'); ?></option>
    <option value="(cc_publicdomain|cc_attribute|cc_sharealike).-(cc_noncommercial|cc_nonderived)"><?php _e('Коммерческое использование и изменение', 'content-egg'); ?></option>
</select>


<select ng-model="query_params.<?php echo $module_id; ?>.imgsz">
    <option value=""><?php _e('Любого размера', 'content-egg'); ?></option>
    <option value="icon"><?php _e('Маленькие', 'content-egg'); ?></option>
    <option value="small|medium|large|xlarge"><?php _e('Средние', 'content-egg'); ?></option>
    <option value="xxlarge"><?php _e('Большие', 'content-egg'); ?></option>
    <option value="huge"><?php _e('Огромные', 'content-egg'); ?></option>
</select>