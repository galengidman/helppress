<?php

get_header('helppress');

helppress_get_template_part('parts/helppress-content', helppress_get_kb_context());

get_sidebar('helppress');

get_footer('helppress');
