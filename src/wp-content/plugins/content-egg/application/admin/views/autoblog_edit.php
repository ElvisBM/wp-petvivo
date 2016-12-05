<?php if (\ContentEgg\application\Plugin::isFree() || \ContentEgg\application\Plugin::isInactiveEnvato()): ?>
    <div class="cegg-maincol">
    <?php endif; ?>
    <div class="wrap">
        <h2>
            <?php if ($item['id']): ?>
                <?php _e('Редактировать автоблоггинг', 'content-egg'); ?>
            <?php else: ?>
                <?php _e('Добавить автоблоггинг', 'content-egg'); ?>
                <?php if ($batch): ?>
                    - <?php _e('пакетное добавление', 'content-egg'); ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (!$batch && !$item['id']): ?>
                <a class="add-new-h2 button-primary" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=content-egg-autoblog-batch-create'); ?>"><?php _e('Пакетное добавление', 'content-egg'); ?></a>
            <?php endif; ?>
            <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=content-egg-autoblog'); ?>"><?php _e('Назад к списку', 'content-egg'); ?></a>
        </h2>

        <?php if (!empty($notice)): ?>
            <div id="notice" class="error"><p><?php echo $notice ?></p></div>
        <?php endif; ?>
        <?php if (!empty($message)): ?>
            <div id="message" class="updated"><p><?php echo $message ?></p></div>
        <?php endif; ?>

        <div id="poststuff">    
            <p>
            </p>    
        </div>    
        <form action="<?php echo add_query_arg('noheader', 'true'); ?>" id="form" method="POST"<?php if ($batch) echo ' enctype="multipart/form-data" accept-charset="utf-8"'; ?>>
            <input type="hidden" name="nonce" value="<?php echo $nonce; ?>"/>
            <input type="hidden" name="item[id]" value="<?php echo $item['id']; ?>"/>
            <div class="metabox-holder" id="poststuff">
                <div id="post-body">
                    <div id="post-body-content">
                        <?php $item['batch'] = $batch; ?>
                        <?php do_meta_boxes('autoblog_create', 'normal', $item); ?>
                        <input type="submit" value="<?php _e('Сохранить', 'content-egg'); ?>" id="autoblog_submit" class="button-primary" name="submit">

                        &nbsp;&nbsp;&nbsp;<?php if ($batch): ?><em><?php _e('Будьте терпеливы, если файл с ключевыми словами имеет большой размер. Не закрывайте страницу до завершения процесса.', 'content-egg'); ?></em><?php endif; ?>

                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        jQuery(document).ready(function() {
            jQuery("#form").submit(function() {
                jQuery("#autoblog_submit").attr("disabled", true);
                return true;
            });
        });
    </script>        

    <?php if (\ContentEgg\application\Plugin::isFree() || \ContentEgg\application\Plugin::isInactiveEnvato()): ?>
    </div>    
    <?php include('_promo_box.php'); ?>
<?php endif; ?>  