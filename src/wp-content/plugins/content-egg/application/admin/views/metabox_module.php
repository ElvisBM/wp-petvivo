<div ng-controllerTMP="<?php echo $module_id; ?>Controller">
    <input type="hidden" name="cegg_data[<?php echo $module_id; ?>]" ng-value="models.<?php echo $module_id; ?>.added | json" /> 
    <input type="hidden" name="cegg_updateKeywords[<?php echo $module_id; ?>]" ng-value="updateKeywords.<?php echo $module_id; ?>" /> 

    <tabset>
        <tab active="activeResultTabs.<?php echo $module_id; ?>">
            <tab-heading>
                <strong><?php echo $module->getName(); ?></strong> 
                <span ng-show="models.<?php echo $module_id; ?>.added.length" class="label" ng-class="{'label-danger':models.<?php echo $module_id; ?>.added_changed, 'label-default':!models.<?php echo $module_id; ?>.added_changed}">{{models.<?php echo $module_id; ?>.added.length}}</span>
            </tab-heading>

            <div class="data_panel">

                <div clas="row">
                    <div class="col-sm-3">
                        <input ng-model="shortcodes.<?php echo $module_id; ?>" select-on-click readonly type="text" class="form-control input-sm" />
                    </div>

                    <div class="col-sm-3">
                        <?php
                        $tpl_manager = ContentEgg\application\components\ModuleTemplateManager::getInstance($module_id);
                        $templates = $tpl_manager->getTemplatesList(true);
                        ?>
                        <?php if ($templates): ?>
                            <select ng-model="selectedTemplate_<?php echo $module_id; ?>" ng-change="buildShortcode('<?php echo $module_id; ?>', selectedTemplate_<?php echo $module_id; ?>);">
                                <option value="">- <?php _e('Output Template for shortcode', 'content-egg'); ?> -</option>
                                <?php foreach ($templates as $id => $name): ?>
                                    <option value="<?php echo esc_attr($id); ?>"><?php echo esc_html($name); ?></option>
                                <?php endforeach; ?>
                            </select>                        
                        <?php endif; ?>
                    </div>

                    <?php if ($module->isAffiliateParser()): ?>
                        <div class="col-md-3">
                            <input id="updateKeyword_<?php echo $module_id; ?>" type="text" ng-model="updateKeywords.<?php echo $module_id; ?>" class="form-control" placeholder="<?php _e('Keyword for the automatic update', 'content-egg'); ?>" />
                        </div>
                    <?php endif; ?>
                    <div class="col-sm-<?php
                    if ($module->isAffiliateParser())
                        echo 3;
                    else
                        echo 6;
                    ?> text-right">
                        <a class='btn btn-default btn-sm' ng-click="deleteAll('<?php echo $module_id; ?>')" ng-confirm-click="<?php _e('Are you sure you want to delete all results?', 'content-egg'); ?>" ng-show='models.<?php echo $module_id; ?>.added.length'><?php _e('Delete all', 'content-egg'); ?></a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <p ng-show="!models.<?php echo $module_id; ?>.added.length && !models.<?php echo $module_id; ?>.processing" class="bg-warning text-center"><br><?php _e('No data found...', 'content-egg'); ?><br><br></p>
            <?php $module->renderResults(); ?>
        </tab>

        <tab active="activeSearchTabs.<?php echo $module_id; ?>" heading="<?php _e('Search', 'content-egg'); ?>">
            <div class="search_panel">
                <div clas="row">
                    <div class="col-md-5">

                        <div class="input-group" ng-show="!models.<?php echo $module_id; ?>.processing">
                            <input type="text" select-on-click ng-model="keywords.<?php echo $module_id; ?>" on-enter="find('<?php echo $module_id; ?>')" class="form-control col-md-6" placeholder="<?php _e('Keyword for search', 'content-egg'); ?>" />
                            <div class="input-group-btn">
                                <button ng-disabled="!keywords.<?php echo $module_id; ?>" ng-click="find('<?php echo $module_id; ?>')" type="button" class="btn btn-info"><?php _e('Find', 'content-egg'); ?></button>
                                <?php if ($module->isAffiliateParser()): ?>
                                    <button ng-disabled="!keywords.<?php echo $module_id; ?>" ng-click="setUpdateKeyword('<?php echo $module_id; ?>')" type="button" class="btn btn-info">&rarr;</button>
                                <?php endif; ?>                                
                            </div>
                        </div>
                        <img ng-show="models.<?php echo $module_id; ?>.processing" src="<?php echo \ContentEgg\PLUGIN_RES . '/img/loader.gif' ?>" />
                    </div>
                    <div class="col-md-6">
                        <div ng-show="!models.<?php echo $module_id; ?>.processing">
                            <?php $module->renderSearchPanel(); ?>
                        </div>
                    </div>
                    <div class="col-sm-1 text-right">
                        <a class='btn btn-default btn-sm' ng-click="addAll('<?php echo $module_id; ?>')" ng-show='models.<?php echo $module_id; ?>.results.length > 0 && !models.<?php echo $module_id; ?>.processing'><?php _e('Add all', 'content-egg'); ?></a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>    

            <?php $module->renderSearchResults(); ?>

            <p ng-show="!models.<?php echo $module_id; ?>.processing && models.<?php echo $module_id; ?>.loaded && models.<?php echo $module_id; ?>.results.length == 0" class="bg-warning text-center"><br><?php _e('Not found...', 'content-egg'); ?><br><br></p>
            <p ng-show="models.<?php echo $module_id; ?>.error && !models.<?php echo $module_id; ?>.processing" class="bg-danger text-center"><br><?php _e('Error:', 'content-egg'); ?> {{models.<?php echo $module_id; ?>.error}}<br><br></p>
        </tab>
    </tabset>
    <div class="row">
        <div class="col-sm-12"><br></div>
    </div>
</div>