<?php

use ContentEgg\application\components\ModuleManager;
?>
<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
    <tbody>

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="name"><?php _e('Название', 'content-egg'); ?></label>
            </th>
            <td>
                <input id="name" name="item[name]" type="text" value="<?php echo esc_attr($item['name']) ?>"
                       size="50" class="code" placeholder="<?php _e('Название для автоблоггинга (необязательно)', 'content-egg'); ?>">
            </td>
        </tr>

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="status"><?php _e('Статус задания', 'content-egg'); ?></label>
            </th>
            <td>
                <select id="status" name="item[status]">
                    <option value="1"<?php if ($item['status']) echo ' selected="selected"'; ?>><?php _e('Работает', 'content-egg'); ?></option>
                    <option value="0"<?php if (!$item['status']) echo ' selected="selected"'; ?>><?php _e('Остановлен', 'content-egg'); ?></option>
                </select>
                <p class="description"><?php _e('Aвтоблоггинг можно приостановить.', 'content-egg'); ?></p>                                
            </td>
        </tr>        

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="run_frequency"><?php _e('Периодичность запуска', 'content-egg'); ?></label>
            </th>
            <td>
                <select id="run_frequency" name="item[run_frequency]">
                    <option value="3600"<?php if ($item['run_frequency'] == 3600) echo ' selected="selected"'; ?>><?php _e('Каждый час', 'content-egg'); ?></option>
                    <option value="17280"<?php if ($item['run_frequency'] == 17280) echo ' selected="selected"'; ?>><?php _e('Пять раз в сутки', 'content-egg'); ?></option>
                    <option value="43200"<?php if ($item['run_frequency'] == 43200) echo ' selected="selected"'; ?>><?php _e('Два раза в сутки', 'content-egg'); ?></option>
                    <option value="86400"<?php if ($item['run_frequency'] == 86400) echo ' selected="selected"'; ?>><?php _e('Один раз в сутки', 'content-egg'); ?></option>
                    <option value="259200"<?php if ($item['run_frequency'] == 259200) echo ' selected="selected"'; ?>><?php _e('Каждые три дня', 'content-egg'); ?></option>
                    <option value="604800"<?php if ($item['run_frequency'] == 604800) echo ' selected="selected"'; ?>><?php _e('Один раз в неделю', 'content-egg'); ?></option>
                    <option value="1209600"<?php if ($item['run_frequency'] == 1209600) echo ' selected="selected"'; ?>><?php _e('Один раз в две недели', 'content-egg'); ?></option>
                </select>  
                <p class="description"><?php _e('Как часто запускать это задание автоблоггинга.', 'content-egg'); ?></p>                
            </td>
        </tr> 
        <?php if (!$batch): ?>
            <tr class="form-field">
                <th valign="top" scope="row">
                    <label for="keywords"><?php _e('Ключевые слова', 'content-egg'); ?></label>
                </th>
                <td>

                    <table width='100%'>
                        <tr>
                            <td valign="top" style="vertical-align: top;" width="50%">
                                <div style="margin-bottom: 10px;">
                                    <button id="tool_capitalise" title="<?php _e('Заглавная Первая Буква Каждого Слова', 'content-egg'); ?>"><?php _e('Заглавная Первая Буква Каждого Слова', 'content-egg'); ?></button>
                                    <button href="#" id="tool_upper_first" title="<?php _e('Заглавная первая буква', 'content-egg'); ?>"><?php _e('Заглавная первая буква', 'content-egg'); ?></button>
                                    <button href="#" id="tool_sort" title="<?php _e('Сортировать в алфавитном порядке', 'content-egg'); ?>"><?php _e('Сортировать в алфавитном порядке', 'content-egg'); ?></button>
                                    <button href="#" id="tool_add_minus" title="<?php _e('Все слова неактивные', 'content-egg'); ?>"><?php _e('Все слова неактивные', 'content-egg'); ?></button>
                                    <button href="#" id="tool_del_minus" title="<?php _e('Все слова активные', 'content-egg'); ?>"><?php _e('Все слова активные', 'content-egg'); ?></button>
                                    <button href="#" id="tool_delete" title="<?php _e('Очистить список', 'content-egg'); ?>"><?php _e('Очистить список', 'content-egg'); ?></button>
                                </div>    
                                <textarea rows="28" id="keywords" name="item[keywords]" class="small-text"><?php echo esc_html($item['keywords']) ?></textarea>
                                <div>
                                    <?php _e('Всего', 'content-egg'); ?>: <b><span id="k_count">0</span></b>
                                </div>
                            </td>
                            <td valign="top" style="vertical-align: top;">
                                <div id="cegg-parsers-tabs">
                                    <ul>
                                        <li><a href="#fragment-1"><?php _e('Подсказки', 'content-egg'); ?></a></li>
                                        <li><a href="#fragment-2"><?php _e('Тренды', 'content-egg'); ?></a></a></li>
                                        <li><a href="#fragment-3"><?php _e('Товары', 'content-egg'); ?></a></a></li>
                                    </ul>
                                    <div id="fragment-1">
                                        <div id="sug_btn_group" class="btn-group" style="margin-bottom: 10px;">
                                            <input id="sug_google" name="sug_radio" value="sug_google" type="radio" checked="checked"><label for="sug_google">Google</label>
                                            <input id="sug_amazon" name="sug_radio" value="sug_amazon" type="radio"><label for="sug_amazon">Amazon</label>
                                            <?php if (\ContentEgg\application\admin\GeneralConfig::getInstance()->option('lang') == 'ru'): ?>
                                                <input id="sug_yandex" name="sug_radio" value="sug_yandex" type="radio"><label for="sug_yandex"><?php _e('Яндекс', 'content-egg'); ?></label>
                                                <input id="sug_market" name="sug_radio" value="sug_market" type="radio"><label for="sug_market"><?php _e('Я.Маркет', 'content-egg'); ?></label>
                                            <?php endif; ?>
                                        </div>    
                                        <input type="text" id="sug_query" placeholder="<?php _e('Начните вводить ключевое слово', 'content-egg'); ?>" />
                                        <select multiple="multiple" id="sug_keywords" style="width: 98%" size="23"></select>
                                    </div>
                                    <div id="fragment-2">
                                        <div style="margin-bottom: 10px;">
                                            <button id="trend_google" type="button">Hot Trends...</button>
                                        </div>
                                        <select multiple="multiple" id="trend_keywords" style="width: 98%" size="24"></select>
                                    </div>
                                    <div id="fragment-3">
                                        <div style="margin-bottom: 10px;">

                                            <select id='amazon_categ'>
                                                <?php foreach ($item['amazon_categs'] as $ac_value => $ac_name): ?>
                                                    <option value='<?php echo $ac_value; ?>'><?php echo $ac_name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <select id='amazon_section'>
                                                <option value='bestsellers'>Bestsellers</option>
                                                <option value='new-releases'>New Releases</option>
                                                <option value='movers-and-shakers'>Movers and Shakers</option>
                                                <option value='top-rated'>Top Rated</option>
                                                <option value='most-wished-for'>Most Wished For</option>
                                                <option value='most-gifted'>Most Gifted</option>
                                            </select>                                        
                                            <button id="trend_goods" type="button"><?php _e('Загрузить...', 'content-egg'); ?></button>

                                        </div>
                                        <select multiple="multiple" id="goods_keywords" style="width: 98%" size="24"></select>


                                    </div>
                                </div>
                            </td>                      
                        </tr>
                    </table>
                    <p class="">
                        <?php _e('Каждое слово - с новой строки.', 'content-egg'); ?>
                        <?php _e('Одно ключевое слово - это один пост.', 'content-egg'); ?>
                        <?php _e('Обработанные слова отмечены [квадратными скобками].', 'content-egg'); ?>
                        <?php _e('Когда обработка всех слов закончится, задание будет остановлено.', 'content-egg'); ?>
                    </p>

                </td>
            </tr>        
        <?php endif; ?>
        <?php if ($batch): ?>



            <tr class="form-field">
                <th valign="top" scope="row">
                    <label for="keywords_file"><?php _e('Ключевые слова', 'content-egg'); ?></label>
                </th>

                <td>
                    <input id="keywords_file" type="file" name="item[keywords_file]" value="" />               

                    <p class="description">

                        <?php _e('Поддерживаются два вида файлов:', 'content-egg'); ?>
                        <br>
                        <br>
                        <b>1. <?php _e('CSV файлы в формате:', 'content-egg'); ?></b>                    
                        <br>
                        category 1;keyword 1<br>
                        category 1;keyword 2<br>
                        category 2;keyword 1<br>
                        category 2;keyword 2<br>
                        ...
                        <br>
                        <?php _e('Разделитель - ";" - точка с запятой.', 'content-egg'); ?><br>
                        <?php _e('Для каждой категории будет создано отдельное задание автоблоггинга.', 'content-egg'); ?>
                        <br><br>
                        <b>2. <?php _e('TXT файлы:', 'content-egg'); ?></b><br>
                        - <?php _e('обычный текстовый файл со списком ключевых слов (каждое слово - с новой строки).', 'content-egg'); ?>
                        <br> 
                        <?php _e('Кодировка файлов должна быть UTF-8.', 'content-egg'); ?>
                    </p>                
                </td>
            </tr>        

        <?php endif; ?>

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="keywords_per_run"><?php _e('Обрабатывать ключевых слов', 'content-egg'); ?></label>
            </th>
            <td>
                <input id="keywords_per_run" name="item[keywords_per_run]" value="<?php echo esc_attr($item['keywords_per_run']) ?>"
                       type="number" class="small-text">
                <p class="description"><?php _e('Сколько ключевых слов обрабатывать за однин раз. Не рекомендуется устанавливать это значение более 5, чтобы излишне не нагружать сервер.', 'content-egg'); ?></p>
            </td>
        </tr>

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="include_modules"><?php _e('Только выбранные модули', 'content-egg'); ?></label>
            </th>
            <td>                
                <div class="cegg-checkboxgroup">
                    <?php foreach (ModuleManager::getInstance()->getParserModules(false) as $module): ?>
                        <div class="cegg-checkbox">
                            <label><input <?php if (in_array($module->getId(), $item['include_modules'])) echo 'checked'; ?> value="<?php echo esc_attr($module->getId()); ?>" type="checkbox" name="item[include_modules][]" /><?php echo $module->getName(); ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="description">
                    <?php _e('Запускать только выбранные модули для этого задания.', 'content-egg'); ?>
                    <?php _e('Если ничего не выбрано, то подразумевается все активные модули на момент запуска автоблоггинга.', 'content-egg'); ?>
                </p>                
            </td>
        </tr>

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="exclude_modules"><?php _e('Исключить модули', 'content-egg'); ?></label>
            </th>
            <td>                
                <div class="cegg-checkboxgroup">
                    <?php foreach (ModuleManager::getInstance()->getParserModules(false) as $module): ?>
                        <div class="cegg-checkbox">
                            <label><input <?php if (in_array($module->getId(), $item['exclude_modules'])) echo 'checked'; ?> value="<?php echo esc_attr($module->getId()); ?>" type="checkbox" name="item[exclude_modules][]" /><?php echo $module->getName(); ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="description">
                    <?php _e('Выбранные модули в этой конфигурации не будут запускаться.', 'content-egg'); ?>
                </p>                
            </td>
        </tr>        

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="template_title"><?php _e('Шаблон заголовка', 'content-egg'); ?></label>
            </th>
            <td>

                <input id="template_title" name="item[template_title]" value="<?php echo esc_attr($item['template_title']) ?>"
                       type="text" class="regular-text ltr">
                <p class="description">
                    <?php _e('Шаблон для заголовка поста.', 'content-egg'); ?>
                    <?php _e('Используйте теги:', 'content-egg'); ?> %KEYWORD%.<br>
                    <?php _e('Для обображения данных плагина используйте специальные теги, например:', 'content-egg'); ?> %Amazon.title%.<br>
                    <?php _e('Вы также можете задать порядковый индекс для доступа к данным плагина:', 'content-egg'); ?> %Amazon.0.price%.<br>
                    <?php _e('Вы можете использовать "формулы" с перечислением синонимов, из которых будет выбран один случайный вариант, например, {Скидка|Распродажа|Дешево}.', 'content-egg'); ?>
                </p>                
            </td>
        </tr>          

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="template_body"><?php _e('Шаблон поста', 'content-egg'); ?></label>
            </th>
            <td>

                <textarea rows="4" id="template_body" name="item[template_body]"><?php echo esc_html($item['template_body']) ?></textarea>
                <p class="description">
                    <?php _e('Шаблон тела поста.', 'content-egg'); ?><br>
                    <?php _e('Вы можете использовать шорткоды, точно также, как вы делаете это в обычных постах, например: ', 'content-egg'); ?>                    
                    [content-egg module=Amazon template=grid]<br>
                    <?php _e('"Форумлы", а также все теги из шаблона заголовка, также будут работать и здесь.', 'content-egg'); ?><br>

                </p>                
            </td>
        </tr>         

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="post_status"><?php _e('Статус поста', 'content-egg'); ?></label>
            </th>
            <td>
                <select id="post_status" name="item[post_status]">
                    <option value="1"<?php if ($item['post_status'] == 1) echo ' selected="selected"'; ?>>Publish</option>                    
                    <option value="0"<?php if ($item['post_status'] == 0) echo ' selected="selected"'; ?>>Pending</option>
                </select>                
            </td>
        </tr>         

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="user_id"><?php _e('Пользователь', 'content-egg'); ?></label>
            </th>
            <td>
                <?php
                wp_dropdown_users(array('name' => 'item[user_id]',
                    'who' => 'authors', 'id' => 'user_id', 'selected' => $item['user_id']));
                ?>
                <p class="description"><?php _e('От имени этого пользователя будут публиковаться посты.', 'content-egg'); ?></p>                
            </td>
        </tr> 

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="category"><?php _e('Категория', 'content-egg'); ?></label>
            </th>
            <td>
                <?php
                $opt = array('name' => 'item[category]', 'id' => 'category', 'selected' => $item['category'], 'hide_empty' => false);
                if ($batch)
                {
                    $opt['show_option_none'] = __('Создать автоматически', 'content-egg'); // -1
                    $opt['selected'] = -1;
                }
                \wp_dropdown_categories($opt);
                ?>
                <p class="description">
                    <?php _e('Категория для постов.', 'content-egg'); ?>
                    <?php if ($batch): ?>
                        <?php _e('"Создать автоматически" - означает, что категории будут созданы на основании данных CSV файла с ключевыми словами и категориями.', 'content-egg'); ?>                    
                    <?php endif; ?>
                </p>
            </td>
        </tr>      


        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="min_modules_count"><?php _e('Требуется минимум модулей', 'content-egg'); ?></label>
            </th>
            <td>
                <input id="min_modules_count" name="item[min_modules_count]" value="<?php echo esc_attr($item['min_modules_count']) ?>"
                       type="number" class="small-text">
                <p class="description"><?php _e('Пост не будет опубликован, если контент не найден для этого количества модулей. ', 'content-egg'); ?></p>                
            </td>
        </tr>        

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="required_modules"><?php _e('Обязательные модули', 'content-egg'); ?></label>
            </th>
            <td>                
                <div class="cegg-checkboxgroup">
                    <?php foreach (ModuleManager::getInstance()->getParserModules(false) as $module): ?>
                        <div class="cegg-checkbox">
                            <label><input <?php if (in_array($module->getId(), $item['required_modules'])) echo 'checked'; ?> value="<?php echo esc_attr($module->getId()); ?>" type="checkbox" name="item[required_modules][]" /><?php echo $module->getName(); ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="description">
                    <?php _e('Пост опубликован не будет, если результаты для этих модулей не найдены.', 'content-egg'); ?>
                </p>                
            </td>
        </tr>         

        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="autoupdate_modules"><?php _e('Автоматическое обновление', 'content-egg'); ?></label>
            </th>
            <td>                
                <div class="cegg-checkboxgroup">
                    <?php foreach (ModuleManager::getInstance()->getAffiliateParsers(false) as $module): ?>
                        <div class="cegg-checkbox">
                            <label><input <?php if (in_array($module->getId(), $item['autoupdate_modules'])) echo 'checked'; ?> value="<?php echo esc_attr($module->getId()); ?>" type="checkbox" name="item[autoupdate_modules][]" /><?php echo $module->getName(); ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="description">
                    <?php _e('Для выбранных модулей текущее ключевое слово будет задано как ключевое слово для автообновления. Выдача модуля будет переодически обновляться в соотвествии с настройкой времени жизни кэша.', 'content-egg'); ?>
                </p>                
            </td>
        </tr>         

    </tbody>
</table>
