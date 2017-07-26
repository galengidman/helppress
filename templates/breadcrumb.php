<ol class="helppress__breadcrumb">
	<?php foreach ( helppress_get_breadcrumb() as $crumb ) : ?>
		<li>
			<a href="<?php echo esc_url( $crumb['url'] ); ?>">
				<span><?php echo $crumb['label']; ?></span>
			</a>
		</li>
	<?php endforeach; ?>
</ol>
