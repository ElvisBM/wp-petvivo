<div class="data_results" ng-if="models.<?php echo $module_id; ?>.added.length">
    <div ui-sortable="{ 'ui-floating': true }" ng-model="models.<?php echo $module_id; ?>.added" class="row">
        <div class="col-md-12 added_data" ng-repeat="data in models.<?php echo $module_id; ?>.added">
            <div class="row" style="padding: 5px;">
                <div class="col-md-1" ng-if="data.img">
                    <img ng-src="{{data.img}}" class="img-responsive" style="max-height: 100px;" />
                </div>
                <div ng-class="data.img ? 'col-md-9' : 'col-md-10'">
                    <input type="text" placeholder="<?php _e('Title', 'content-egg'); ?>" ng-model="data.title" class="form-control" style="margin-bottom: 5px;">
                    <textarea type="text" placeholder="<?php _e('Description', 'content-egg'); ?>" rows="2" ng-model="data.description" class="col-sm-12 "></textarea>
                </div>
                <div class="col-md-2">
                    <a href="{{data.url}}" target="_blank"><span ng-show="data.domain"><img src="http://www.google.com/s2/favicons?domain={{data.domain}}"> {{data.domain}}</span><span ng-hide="data.domain"><?php _e('Go to ', 'content-egg'); ?></span></a><br><br>
                    <a ng-click="delete(data, '<?php echo $module_id; ?>')"><?php _e('Delete', 'content-egg'); ?></a><br>
                    <small class="text-muted" ng-show="data.ean"><br><?php _e('EAN:'); ?> {{data.ean}}</small>
                    <small class="text-muted" ng-show="data.last_update"><br><?php _e('Last update:'); ?> {{data.last_update * 1000 | date:'shortDate'}}</small>
                </div>  
            </div>
            
        </div>
    </div>
</div>