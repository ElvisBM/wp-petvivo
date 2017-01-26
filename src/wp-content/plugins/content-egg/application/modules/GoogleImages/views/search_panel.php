<select ng-model="query_params.<?php echo $module_id; ?>.license">
    <option value=""><?php _e('Any license', 'content-egg'); ?></option>
    <option value="(cc_publicdomain|cc_attribute|cc_sharealike|cc_noncommercial|cc_nonderived)"><?php _e('Any Creative Commons', 'content-egg'); ?></option>
    <option value="(cc_publicdomain|cc_attribute|cc_sharealike|cc_nonderived).-(cc_noncommercial)"><?php _e('With Allow of commercial use', 'content-egg'); ?></option>
    <option value="(cc_publicdomain|cc_attribute|cc_sharealike|cc_noncommercial).-(cc_nonderived)"><?php _e('Allowed change', 'content-egg'); ?></option>
    <option value="(cc_publicdomain|cc_attribute|cc_sharealike).-(cc_noncommercial|cc_nonderived)"><?php _e('Commercial use and change', 'content-egg'); ?></option>
</select>


<select ng-model="query_params.<?php echo $module_id; ?>.imgsz">
    <option value=""><?php _e('Any size', 'content-egg'); ?></option>
    <option value="icon"><?php _e('Small', 'content-egg'); ?></option>
    <option value="small|medium|large|xlarge"><?php _e('Medium', 'content-egg'); ?></option>
    <option value="xxlarge"><?php _e('Large', 'content-egg'); ?></option>
    <option value="huge"><?php _e('Huge', 'content-egg'); ?></option>
</select>