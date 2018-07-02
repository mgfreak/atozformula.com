<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-ab-page-testing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}
?>
<div class="page-search-input">
	<input type="text" id="page-search-<#= item.cid #>" class="page-search" data-bind="post_title" value="<#= item.get('post_title') #>"/>
	<label for="page-search-<#= item.cid #>">
		<# if( item.get('type')=='monetary' ) { #>
			<?php echo __( 'Search Thank You Page ', Thrive_AB::T ) ?>
		<# } else { #>
			<?php echo __( 'Search Goal Page', Thrive_AB::T ) ?>
		<# }  #>
	</label>
</div>
<div class="page-search-options">
	<a href="javascript:void(0)" class="thrive-ab-edit-page tvd-btn-flat tvd-btn-flat-secondary tvd-btn-flat-primary" target="_blank" <#= item.get('post_title')? '': 'style="display:none"' #>>
		<?php echo __( 'Edit Page', Thrive_AB::T ) ?>
	</a>
	<a href="javascript:void(0)" class="thrive-ab-preview-page tvd-btn-flat tvd-btn-flat-secondary tvd-btn-flat-primary" target="_blank" <#= item.get('post_title')? '': 'style="display:none"' #>>
		<?php echo __( 'Preview', Thrive_AB::T ) ?>
	</a>
	<a href="javascript:void(0)" class="thrive-ab-remove-page tvd-right tvd-btn-flat tvd-btn-flat-secondary tvd-btn-flat-dark" target="_blank">
		<?php echo __( 'Remove', Thrive_AB::T ) ?>
	</a>
</div>
