<?php

if ( ! helppress_get_option( 'breadcrumb' ) ) {
	return;
}

?>

<ol class="helppress-breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
	<?php $i = 1; foreach ( helppress_get_breadcrumb() as $crumb ) : ?>
		<li
			class="helppress-breadcrumb__crumb"
			itemprop="itemListElement"
			itemscope
			itemtype="http://schema.org/ListItem"
			data-sep="<?php echo esc_attr( helppress_get_option( 'breadcrumb_sep' ) ); ?>">
			<a href="<?php echo esc_url( $crumb['url'] ); ?>" itemprop="item">
				<span itemprop="name"><?php echo $crumb['label']; ?></span>
				<meta itemprop="position" content="<?php echo esc_attr( $i ); ?>">
			</a>
		</li>
	<?php $i++; endforeach; ?>
</ol>
