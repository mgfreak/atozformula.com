<?php
/**
 * Created by PhpStorm.
 * User: Ovidiu
 * Date: 1/16/2018
 * Time: 2:18 PM
 */
?>

<div class="tab-center">
	<div class="tvd-row">
		<div class="tvd-col tvd-s12">
			<span class="tab-dash-title"><?php echo __( 'Last 30 Days Stats', Thrive_AB::T ); ?></span>
		</div>
	</div>
	<div class="tvd-row">
		<div class="tvd-col tvd-s12">
			<span class="tab-dash-subtitle"><?php //echo __( '(Applies for running tests only)', Thrive_AB::T ); ?></span>
		</div>
	</div>
</div>

<div class="tvd-row" style="margin-bottom: 40px">
	<div class="tvd-col tvd-s4">
		<div class="tab-overview-box">
			<p class="tab-stats-text">
				<span class="tvd-icon-eye tvd-stats-icon"></span>
				<span><?php echo __( 'Total Unique Visitors', Thrive_AB::T ); ?></span>
			</p>
			<hr>
			<p class="tab-stats-number tab-stats-blue"><#= stats.unique_visitors #></p>
		</div>
	</div>
	<div class="tvd-col tvd-s4">
		<div class="tab-overview-box">
			<p class="tab-stats-text">
				<span class="tvd-icon-paper-plane tvd-stats-icon"></span>
				<span><?php echo __( 'Total Conversions', Thrive_AB::T ); ?></span>
			</p>
			<hr>
			<p class="tab-stats-number tab-stats-blue"><#= stats.total_conversions #></p>
		</div>
	</div>
	<div class="tvd-col tvd-s4">
		<div class="tab-overview-box">
			<p class="tab-stats-text">
				<span class="tvd-icon-line-chart tvd-stats-icon"></span>
				<span><?php echo __( 'Conversion Rate', Thrive_AB::T ); ?></span>
			</p>
			<hr>
			<p class="tab-stats-number tab-stats-green"><#= stats.conversion_rate #>%</p>
		</div>
	</div>
</div>

<hr>
<br>

<div class="tvd-row tab-no-margin">
	<div class="tvd-col tvd-s6">
		<h3><?php echo __( 'Running A/B Tests Overview', Thrive_AB::T ); ?></h3>
	</div>
	<div class="tvd-col tvd-s6 tab-right">
		<div class="tvd-input-field tvd-prefix tvd-input-field-limit">
			<i class="tvd-icon-search"></i>
			<input type="text" class="tab-running-search-input tvd-no-margin" placeholder="<?php echo __( 'Search tests...', Thrive_AB::T ); ?>" value=""/>
		</div>
	</div>
</div>
<div class="tvd-row">
	<div class="tvd-col tvd-s12">
		<table class="tvd-collection">
			<thead>
			<tr>
				<td>
					<div class="tvd-truncate-on-small" data-popup="<?php echo __( 'Test Name', Thrive_AB::T ); ?>">
						<h5 class="tvd-truncate-on-small-el"><?php echo __( 'Test Name', Thrive_AB::T ); ?></h5>
					</div>
				</td>
				<td>
					<div class="tvd-truncate-on-small" data-popup="<?php echo __( 'Date Started', Thrive_AB::T ); ?>">
						<h5 class="tvd-truncate-on-small-el"><?php echo __( 'Date Started', Thrive_AB::T ); ?></h5>
					</div>
				</td>
				<td>
					<div class="tvd-truncate-on-small" data-popup="<?php echo __( 'On Page', Thrive_AB::T ); ?>">
						<h5 class="tvd-truncate-on-small-el"><?php echo __( 'On Page', Thrive_AB::T ); ?></h5>
					</div>
				</td>
				<td>
					<div class="tvd-truncate-on-small" data-popup="<?php echo __( 'Test Goal', Thrive_AB::T ); ?>">
						<h5 class="tvd-truncate-on-small-el">
							<?php echo __( 'Test Goal', Thrive_AB::T ); ?>
						</h5>
					</div>
				</td>
				<td>
					<div class="tvd-truncate-on-small" data-popup="<?php echo __( 'Unique Visitors', Thrive_AB::T ); ?>">
						<h5 class="tvd-truncate-on-small-el"><?php echo __( 'Unique Visitors', Thrive_AB::T ); ?></h5>
					</div>
				</td>
				<td>
					<div class="tvd-truncate-on-small" data-popup="<?php echo __( 'Conversions', Thrive_AB::T ); ?>">
						<h5 class="tvd-truncate-on-small-el">
							<?php echo __( 'Conversions', Thrive_AB::T ); ?>
						</h5>
					</div>
				</td>
				<td>
					<div class="tvd-truncate-on-small" data-popup="<?php echo __( 'Actions', Thrive_AB::T ); ?>">
						<h5 class="tvd-truncate-on-small-el">
							<?php echo __( 'Actions', Thrive_AB::T ); ?>
						</h5>
					</div>
				</td>
			</tr>
			</thead>
			<tbody class="tab-running-test-items-list"></tbody>
		</table>
	</div>
</div>
<div class="tvd-row">
	<div class="tvd-col tvd-s6 tvd-offset-s6 tab-running-pagination"></div>
</div>


<div class="tvd-row tab-no-margin">
	<div class="tvd-col tvd-s6">
		<h3><?php echo __( 'Completed Tests', Thrive_AB::T ); ?></h3>
	</div>
	<div class="tvd-col tvd-s6 tab-right">
		<div class="tvd-input-field tvd-prefix tvd-input-field-limit">
			<i class="tvd-icon-search"></i>
			<input type="text" class="tab-completed-search-input tvd-no-margin" placeholder="<?php echo __( 'Search tests...', Thrive_AB::T ); ?>" value=""/>
		</div>
	</div>
</div>
<div class="tvd-row">
	<div class="tvd-col tvd-s12">
		<table class="tvd-collection">
			<thead>
			<tr>
				<td>
					<div class="tvd-truncate-on-small" data-popup="<?php echo __( 'Test Name', Thrive_AB::T ); ?>">
						<h5 class="tvd-truncate-on-small-el"><?php echo __( 'Test Name', Thrive_AB::T ); ?></h5>
					</div>
				</td>
				<td>
					<div class="tvd-truncate-on-small" data-popup="<?php echo __( 'End Date', Thrive_AB::T ); ?>">
						<h5 class="tvd-truncate-on-small-el"><?php echo __( 'End Date', Thrive_AB::T ); ?></h5>
					</div>
				</td>
				<td>
					<div class="tvd-truncate-on-small" data-popup="<?php echo __( 'On Page', Thrive_AB::T ); ?>">
						<h5 class="tvd-truncate-on-small-el"><?php echo __( 'On Page', Thrive_AB::T ); ?></h5>
					</div>
				</td>
				<td>
					<div class="tvd-truncate-on-small" data-popup="<?php echo __( 'Test Goal', Thrive_AB::T ); ?>">
						<h5 class="tvd-truncate-on-small-el">
							<?php echo __( 'Test Goal', Thrive_AB::T ); ?>
						</h5>
					</div>
				</td>
				<td>
					<div class="tvd-truncate-on-small" data-popup="<?php echo __( 'Actions', Thrive_AB::T ); ?>">
						<h5 class="tvd-truncate-on-small-el">
							<?php echo __( 'Actions', Thrive_AB::T ); ?>
						</h5>
					</div>
				</td>
			</tr>
			</thead>
			<tbody class="tab-completed-test-items-list"></tbody>
		</table>
	</div>
</div>
<div class="tvd-row">
	<div class="tvd-col tvd-s6 tvd-offset-s6 tab-completed-pagination"></div>
</div>
