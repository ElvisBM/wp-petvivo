<?php \wp_nonce_field('contentegg_metabox', 'contentegg_nonce'); ?>

<div clas="row">
    <div class="col-sm-5">
        <div class="input-group">

            <input ng-disabled="processCounter" type="text" ng-model="global_keywords" select-on-click on-enter="global_findAll()" class="form-control col-md-6" placeholder="<?php _e('Введите ключевое слово', 'content-egg'); ?>" aria-label="<?php _e('Введите ключевое слово', 'content-egg'); ?>">
            <div class="input-group-btn">
                <button ng-disabled='processCounter || !global_keywords' ng-click="global_findAll()" type="button" class="btn btn-info"><?php _e('Найти все', 'content-egg'); ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-1">
    </div>

    <div class="col-sm-5">
        <?php
        $tpl_manager = ContentEgg\application\components\BlockTemplateManager::getInstance();
        $templates = $tpl_manager->getTemplatesList(true);
        ?>

        <div class="row">
            <div class="col-sm-6">
                <input ng-model="blockShortcode" select-on-click readonly type="text" class="form-control input-sm" />                
            </div>
            <div class="col-sm-6" ng-init="selectedBlockTemplate = '<?php echo key($templates); ?>';
                    buildBlockShortcode();">
                <select ng-model="selectedBlockTemplate" ng-change="buildBlockShortcode();">
                    <?php foreach ($templates as $id => $name): ?>
                        <option value="<?php echo esc_attr($id); ?>"><?php echo esc_html($name); ?></option>
                    <?php endforeach; ?>
                </select>                        

            </div>
        </div>

    </div>

    <div class="col-sm-1 text-right">
        <button ng-show='!processCounter && global_isSearchResults()' ng-click="global_addAll()" type="button" class="btn btn-default btn-sm"><?php _e('Добавить все', 'content-egg'); ?></button>
        <button ng-show='global_isAddedResults()' ng-click="global_deleteAll()" ng-confirm-click="<?php _e('Вы действительно хотите удалить результаты всех модулей?', 'content-egg'); ?>" type="button" class="btn btn-default btn-sm"><?php _e('Удалить все', 'content-egg'); ?></button>
    </div>
</div>
<div class="row">
    <div class="col-sm-12"><hr></div>
</div>