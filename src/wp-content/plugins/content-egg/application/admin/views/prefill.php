<?php

use ContentEgg\application\components\ModuleManager;
?>

<?php if (\ContentEgg\application\Plugin::isFree() || \ContentEgg\application\Plugin::isInactiveEnvato()): ?>
    <div class="cegg-maincol">
    <?php endif; ?>
    <div class="wrap">
        <h2>
            <?php _e('Fill', 'content-egg'); ?>
        </h2>
        <p>
            <?php _e('This extension will fill module\'s data for all existed posts.', 'content-egg'); ?>
            <?php _e('All existing data and keywords will not be erased or overwritten.', 'content-egg'); ?>
        </p>
        <table class="form-table">
            <tr>
                <th scope="row"><label for="module_id"><?php _e('Add data for module', 'content-egg'); ?></label></th>
                <td>
                    <select id="module_id">
                        <?php foreach (ModuleManager::getInstance()->getParserModules() as $module): ?>
                            <option value="<?php echo $module->getId(); ?>"><?php echo esc_html($module->getName()); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="keyword_source"><?php _e('Keyword source', 'content-egg'); ?></label></th>
                <td>
                    <select id="keyword_source">
                        <option value="_density"><?php _e('Calculate as base of the density of keywords inside post', 'content-egg'); ?></option>                                                
                        <option value="_title"><?php _e('Title for post', 'content-egg'); ?></option>
                        <option value="_tags"><?php _e('Post tags', 'content-egg'); ?></option>
                        <?php foreach (ModuleManager::getInstance()->getAffiliateParsers() as $module): ?>
                            <option value="<?php echo $module->getId(); ?>"><?php _e('Copy from', 'content-egg'); ?> <?php echo esc_html($module->getName()); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="autoupdate"><?php _e('Autoupdate', 'content-egg'); ?></label></th>
                <td>
                    <label><input id="autoupdate" type="checkbox" checked="1" value="1"> <?php _e('Add Keyword for the automatic update', 'content-egg'); ?></label>
                    <p class="description"><?php _e('Only for those modules, which have autoupdate function.', 'content-egg'); ?></p>
                </td>
            </tr>            

            <tr>
                <th scope="row"><label for="keyword_count"><?php _e('Number of words', 'content-egg'); ?></label></th>
                <td>
                    <select id="keyword_count">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?php echo $i; ?>"<?php if ($i == 5) echo ' selected="selected"'; ?>><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <p class="description"><?php _e('Maximum words for one search query.', 'content-egg'); ?></p>
                </td>
            </tr>      
            
            <tr>
                <th scope="row"><label for="minus_words"><?php _e('"Minus" words', 'content-egg'); ?></label></th>
                <td>
                    <input id="minus_words" type="text" class="regular-text">
                    <p class="description"><?php _e('Remove these words from keyword. You can set several minus words/phrases with commas.', 'content-egg'); ?></p>
                </td>
            </tr>              
            
        </table>        

        <div id="progressbar" name="progressbar"></div>

        <div>
            <br>
            <button class="button-primary" type="button" id="start_prefill"><?php _e('Start', 'content-egg'); ?></button>
            <button class="button-primary" type="button" id="start_prefill_begin"><?php _e('Run again', 'content-egg'); ?></button>
            <button class="button-secondary" type="button" id="stop_prefill" disabled><?php _e('Stop', 'content-egg'); ?></button>

            <span id="ajaxWaiting__" style="display:none;"><img src="<?php echo \ContentEgg\PLUGIN_RES . '/img/ajax-loader.gif' ?>" /></span>
            <span id="ajaxBusy" style="display:none;"><img src="<?php echo \ContentEgg\PLUGIN_RES . '/img/ajax-loader.gif' ?>" /></span>


        </div>

        <div class="egg-prefill-log" id="logs"></div>



    </div>
    <?php if (\ContentEgg\application\Plugin::isFree() || \ContentEgg\application\Plugin::isInactiveEnvato()): ?>
    </div>    
    <?php include('_promo_box.php'); ?>
<?php endif; ?>  