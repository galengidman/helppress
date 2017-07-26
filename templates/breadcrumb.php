<ol class="helppress__breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
	<?php $i = 1; foreach ( helppress_get_breadcrumb() as $crumb ) : ?>
		<li class="helppress__breadcrumb-crumb" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
			<a href="<?php echo esc_url( $crumb['url'] ); ?>" class="helppress__breadcrumb-link" itemprop="item">
				<span itemprop="name"><?php echo $crumb['label']; ?></span>
				<meta itemprop="position" content="<?php echo esc_attr( $i ); ?>">
			</a>
		</li>
	<?php $i++; endforeach; ?>
</ol>
