<?php
/**
 * Created by PhpStorm.
 * User: Ovidiu
 * Date: 1/16/2018
 * Time: 11:05 AM
 */
?>
<ul class="clearfix">
	<# links.each( function( item, index ) { item.has_link = index < links.size() - 1 #>
	<li class="tvd-breadcrumb <#= ( item.has_link ? '' : ' tqb-no-link' ) #>">
		<# if ( item.has_link ) { #><a href="<#= item.get_url() #>"><# } #>
			<#= _.escape ( item.get ( 'label' ) ) #>
			<# if ( item.has_link ) { #></a><# } #>
	</li>
	<# } ) #>
</ul>
