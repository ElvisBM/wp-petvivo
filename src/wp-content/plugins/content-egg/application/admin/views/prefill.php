<?php

use ContentEgg\application\components\ModuleManager;
?>

<?php if (\ContentEgg\application\Plugin::isFree() || \ContentEgg\application\Plugin::isInactiveEnvato()): ?>
    <div class="cegg-maincol">
    <?php endif; ?>
    <div class="wrap">
        <h2>
            <?php _e('Заполнить', 'content-egg'); ?>
        </h2>

        <p>
            <?php _e('Эта утилита заполняет данные модулей для всех существующих постов.', 'content-egg'); ?>
            <?php _e('Существующие данные и ключевые слова для автообновления не перезатираются!', 'content-egg'); ?>

        </p>

        <table class="form-table">

            <tr>
                <th scope="row"><label for="module_id"><?php _e('Добавить данные для модуля', 'content-egg'); ?></label></th>
                <td>
                    <select id="module_id">
                        <?php foreach (ModuleManager::getInstance()->getParserModules() as $module): ?>
                            <option value="<?php echo $module->getId(); ?>"><?php echo esc_html($module->getName()); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="keyword_source"><?php _e('Источник ключевого слова', 'content-egg'); ?></label></th>
                <td>
                    <select id="keyword_source">
                        <option value="_density"><?php _e('Вычислить на основании плотности ключевых слов поста', 'content-egg'); ?></option>                                                
                        <option value="_title"><?php _e('Заголовк поста', 'content-egg'); ?></option>
                        <option value="_tags"><?php _e('Тэги поста', 'content-egg'); ?></option>
                        <?php foreach (ModuleManager::getInstance()->getAffiliateParsers() as $module): ?>
                            <option value="<?php echo $module->getId(); ?>"><?php _e('Копировать с', 'content-egg'); ?> <?php echo esc_html($module->getName()); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="autoupdate"><?php _e('Автообновление', 'content-egg'); ?></label></th>
                <td>
                    <label><input id="autoupdate" type="checkbox" checked="1" value="1"> <?php _e('Добавить ключевое слово для автообновления', 'content-egg'); ?></label>
                    <p class="description"><?php _e('Только для модулей, которые имеют функцию автообновления.', 'content-egg'); ?></p>
                </td>
            </tr>            

            <tr>
                <th scope="row"><label for="keyword_count"><?php _e('Количество слов', 'content-egg'); ?></label></th>
                <td>
                    <select id="keyword_count">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?php echo $i; ?>"<?php if ($i == 5) echo ' selected="selected"'; ?>><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <p class="description"><?php _e('Максимум слов в поисковом запросе.', 'content-egg'); ?></p>

                </td>
            </tr>            
        </table>        


        <div id="progressbar" name="progressbar"></div>

        <div>
            <br>
            <button class="button-primary" type="button" id="start_prefill"><?php _e('Старт', 'content-egg'); ?></button>
            <button class="button-primary" type="button" id="start_prefill_begin"><?php _e('Начать сначала', 'content-egg'); ?></button>
            <button class="button-secondary" type="button" id="stop_prefill" disabled><?php _e('Стоп', 'content-egg'); ?></button>

            <span id="ajaxWaiting__" style="display:none;"><img src="<?php echo \ContentEgg\PLUGIN_RES . '/img/ajax-loader.gif' ?>" /></span>
            <span id="ajaxBusy" style="display:none;"><img src="<?php echo \ContentEgg\PLUGIN_RES . '/img/ajax-loader.gif' ?>" /></span>


        </div>

        <div class="egg-prefill-log" id="logs"></div>



    </div>
    <?php if (\ContentEgg\application\Plugin::isFree() || \ContentEgg\application\Plugin::isInactiveEnvato()): ?>
    </div>    
    <?php include('_promo_box.php'); ?>
<?php endif; ?>  