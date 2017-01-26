<div class="text-center mt20 mb20">
<a href="<?php echo esc_url($afflink) ?>" class="re_track_btn wpsm-button rehub_main_btn btn_offer_block" target="_blank" rel="nofollow">
	<span><strong><?php echo esc_html($btn_txt) ?></strong></span>
	<?php if($merchant):?>
		<span class="aff_tag mtinside">@<?php echo $merchant; ?></span>
	<?php else:?>
		<span class="aff_tag mtinside">@<?php echo $domain; ?></span>
	<?php endif;?>
</a>    
</div>     