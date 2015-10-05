<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Adcade Help Center 2015
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php //ahc2015_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php 
		the_content(); 
		$instantiatable = (types_render_field("instantiatable", array("output" => "raw")) == 1);
		if (!$instantiatable){ 
		?>
			<p><strong>NOTE:</strong> <?php echo ahc2015_adscript_link_html(get_the_ID()); ?> can not be directly instantiated.</p>
		<?php } ?>
		<h2>Location</h2>
		<p><?php echo types_render_field("location"); ?></p>

		<?php 
		?>
		<?php if ($instantiatable){ 
			/* Need to work this in in the future...  for now rely on the code example field 
			$uses_initial_properties_object = (types_render_field("uses-initial-properties-object", array("output" => "raw")) == 1); 
			$recommended_properties = get_field('recommended_properties'); //returns array of post objects
			?>
			<h2>Creating a <?php echo ahc2015_adscript_link_html(get_the_ID()); ?></h2>
			<p>My Constructor and parameters (required parameters)
			
				title
				description
				ACF type(s)
				required?
					default value
				unique keys
					title
					description
					ACF type(s)
					required?
						default value</p>
			<?php */ ?>
			<h2>Usage Example</h2>

			<?php echo CrayonWP::highlight(types_render_field("code-example", array( ))); ?>
		<?php } ?>

		<?php 
		$all_properties_posts = ahc2015_all_properties( get_the_ID() ); 
		if (!empty($all_properties_posts)){?>
			<h2 id="properties-list">Properties</h2>
	 		<p><a id="showHideInheritedPropertiesLink" href="#properties-list">Click here to <span class="toggle-text">show</span> inherited properties</a></p>
	 		<ul id="properties-summary">
			<?php 
			foreach ($all_properties_posts as $all_properties_post) {
				$this_property_parent_post_id = get_post_meta($all_properties_post->ID, "_wpcf_belongs_adscript-api_id")[0];
				$this_property_parent_post = get_post($this_property_parent_post_id);
				$this_property_not_my_own = ($this_property_parent_post_id != get_the_ID());
				//$this_property_params = ahc2015_property_params($all_properties_post->ID);
				$this_property_can_be_a_number = false;
				$this_property_is_static = (get_post_meta($all_properties_post->ID, "wpcf-static", true) == 1);
				$this_property_is_read_only = (get_post_meta($all_properties_post->ID, "wpcf-read-only", true) == 1);
				$this_property_is_updatable = (get_post_meta($all_properties_post->ID, "wpcf-updatable", true) == 1);
				$this_property_is_required_at_creation = (get_post_meta($all_properties_post->ID, "wpcf-required-at-creation", true) == 1);
				$this_property_headline = ahc2015_adscript_link_html($this_property_parent_post_id, $all_properties_post->post_title, $all_properties_post->post_title, ($this_property_not_my_own ? "" : "self-referential"));
				$this_property_types = get_field('type', $all_properties_post->ID);
				$this_property_headline .= " : ";
				foreach ($this_property_types as $this_property_type) {
					if ($this_property_type == "adscript"){
						$this_property_adscript_types = get_field('adscript_type', $all_properties_post->ID);
						foreach ($this_property_adscript_types as $this_property_adscript_type) {
							$this_property_headline .= ahc2015_adscript_link_html($this_property_adscript_type->ID) . " OR ";
						}
					} else {
						if ($this_property_type == "number")
							$this_property_can_be_a_number = true;
						$type_field = get_field_object('type', $all_properties_post->ID);
						$type_label = $type_field['choices'][ $this_property_type ];
						$this_property_headline .= $type_label . " OR ";
					}
				}
				$this_property_headline = rtrim($this_property_headline, " OR ");
				if (!$this_property_is_required_at_creation)
				{
					$this_property_default_value = get_post_meta($all_properties_post->ID, "wpcf-default-value", true);
					$this_property_headline .= ' <i>| Default: ' . (empty($this_property_default_value) ? ahc2015_default_empty_value($this_property_types[0]) : $this_property_default_value) . "</i>";
				}

				?>
				<li class="property<?php if ($this_property_not_my_own) echo " inherited invisible"; else echo " original";?>">
				<?php if ($this_property_not_my_own)
				{
					//This is from another Class
					?><strong><?php echo $this_property_headline; ?></strong> <i>inherited from <?php echo ahc2015_adscript_link_html($this_property_parent_post_id);?></i><br/><?php
				}else{
					//This is from this Class
					?><strong><?php echo $this_property_headline; ?></strong><br/><?php
				}
				?>
				<span><?php 
				if ($this_property_is_required_at_creation)
					echo "<em>[required at creation]</em> ";
				if ($this_property_can_be_a_number && $this_property_is_updatable)
					echo "[tweenable] ";
				if ($this_property_is_static)
					echo "[static] ";
				if ($this_property_is_read_only)
					echo "[read-only] ";
				else if (!$this_property_is_updatable)
					echo "[cannot be updated] ";
				
				echo get_post_excerpt_by_id($all_properties_post->ID);?></span></li><?php
			}
			?>
			</ul>
		<?php 
		} 
		$all_methods_posts = ahc2015_all_methods( get_the_ID() ); 
		if (!empty($all_methods_posts)){?>
			<h2 id="methods-list">Methods</h2>
			<p><a id="showHideInheritedMethodsLink" href="#methods-list">Click here to <span class="toggle-text">show</span> inherited methods</a></p>
			<ul id="methods-summary">
			<?php 
			foreach ($all_methods_posts as $all_methods_post) {
				$this_method_parent_post_id = get_post_meta($all_methods_post->ID, "_wpcf_belongs_adscript-api_id")[0];
				$this_method_parent_post = get_post($this_method_parent_post_id);
				$this_method_not_my_own = ($this_method_parent_post_id != get_the_ID());
				$this_method_params = ahc2015_method_params($all_methods_post->ID);
				$this_method_is_static = (types_render_field("static", array("output" => "raw")) == 1);
				$this_method_headline = ahc2015_adscript_link_html($this_method_parent_post_id, $all_methods_post->post_title, $all_methods_post->post_title . '()', ($this_method_not_my_own ? "" : "self-referential"));
				$this_method_headline .= "(";
				foreach ($this_method_params as $this_method_param) {
					$this_method_param_text = $this_method_param->post_title;

					$this_method_param_types = get_field('type', $this_method_param->ID);
					$this_method_param_types_text = "";
					foreach ($this_method_param_types as $this_method_param_type) {
						if ($this_method_param_type == "adscript"){
							$adscript_types = get_field('adscript_type', $this_method_param->ID);
							foreach ($adscript_types as $adscript_type) {
								$this_method_param_types_text .= ahc2015_adscript_link_html($adscript_type->ID) . " OR ";
							}
						} else {
							$this_method_param_type_field = get_field_object('type', $this_method_param->ID);
							$this_method_param_type_label = $this_method_param_type_field['choices'][ $this_method_param_type ];
							$this_method_param_types_text .= $this_method_param_type_label . " OR ";
						}
					}
					$this_method_param_types_text = rtrim($this_method_param_types_text, " OR ");
					$this_method_param_text .= ":" . $this_method_param_types_text;

					//$this_method_param->post_content
					
					$this_method_param_required = (get_post_meta($this_method_param->ID, "wpcf-is-required", true) == 1);
					if (!$this_method_param_required)
					{
						$this_method_param_default_value = get_post_meta($this_method_param->ID, "wpcf-default-value", true);
						$this_method_param_text .= ' = ' . (empty($this_method_param_default_value) ? ahc2015_default_empty_value($this_method_param_types[0]) : $this_method_param_default_value);
					}

					$this_method_headline .= $this_method_param_text;
					$this_method_headline .= ", ";
				}
				$this_method_headline = rtrim($this_method_headline, ", ") . ") : ";
				$return_types = get_field('return_type', $all_methods_post->ID);
				foreach ($return_types as $return_type) {
					if ($return_type == "adscript"){
						$adscript_return_types = get_field('adscript_return_type', $all_methods_post->ID);
						foreach ($adscript_return_types as $adscript_return_type) {
							$this_method_headline .= ahc2015_adscript_link_html($adscript_return_type->ID) . " OR ";
						}
					} else {
						$return_type_field = get_field_object('return_type', $all_methods_post->ID);
						$return_type_label = $return_type_field['choices'][ $return_type ];
						$this_method_headline .= $return_type_label . " OR ";
					}
				}
				$this_method_headline = rtrim($this_method_headline, " OR ");
				?>
				<li class="method<?php if ($this_method_not_my_own) echo " inherited invisible"; else echo " original"; ?>">
				<?php if ($this_method_not_my_own)
				{
					//This is from another Class
					?><strong><?php echo $this_method_headline; ?></strong> <i>inherited from <?php echo ahc2015_adscript_link_html($this_method_parent_post_id, $this_method_parent_post->post_title); ?></i><br/><?php
				}else{
					//This is from this Class
					?><strong><?php echo $this_method_headline; ?></strong><br/><?php
				} ?>
				<span><?php echo get_post_excerpt_by_id($all_methods_post->ID);?></span></li><?php
			}
			?>
			</ul>
		<?php
		}
		?>

		<?php 
		$original_properties_posts = ahc2015_original_properties( get_the_ID() ); 
		if (!empty($original_properties_posts)){?>
			<h2 id="properties-details">Property Details</h2>
		<?php 
		}
		$first_item = true;
		foreach ($original_properties_posts as $original_properties_post) {
			if (!$first_item)
			{
				?><hr/><?php
			}
			//$this_property_params = ahc2015_property_params($original_properties_post->ID);
			$this_property_can_be_a_number = false;
			$this_property_is_static = (get_post_meta($original_properties_post->ID, "wpcf-static", true) == 1);
			$this_property_is_read_only = (get_post_meta($original_properties_post->ID, "wpcf-read-only", true) == 1);
			$this_property_is_updatable = (get_post_meta($original_properties_post->ID, "wpcf-updatable", true) == 1);
			$this_property_is_required_at_creation = (get_post_meta($original_properties_post->ID, "wpcf-required-at-creation", true) == 1);
			$this_property_headline = $original_properties_post->post_title;
			$this_property_types = get_field('type', $original_properties_post->ID);
			$this_property_has_unique_get_type = get_field('is_unique_get_type', $original_properties_post->ID);
			$this_property_headline .= " : ";
			foreach ($this_property_types as $this_property_type) {
				if ($this_property_type == "adscript"){
					$this_property_adscript_types = get_field('adscript_type', $original_properties_post->ID);
					foreach ($this_property_adscript_types as $this_property_adscript_type) {
						$this_property_headline .= ahc2015_adscript_link_html($this_property_adscript_type->ID) . " OR ";
					}
				} else {
					if ($this_property_type == "number")
						$this_property_can_be_a_number = true;
					$type_field = get_field_object('type', $original_properties_post->ID);
					$type_label = $type_field['choices'][ $this_property_type ];
					$this_property_headline .= $type_label . " OR ";
				}
			}
			$this_property_headline = rtrim($this_property_headline, " OR ");
			if ($this_property_has_unique_get_type) {
				$this_property_headline .= " [w/ Unique GET types: ";
				$this_property_get_types = get_field('type', $original_properties_post->ID);
				foreach ($this_property_get_types as $this_property_get_type) {
					if ($this_property_get_type == "adscript"){
						$this_property_adscript_get_types = get_field('unique_adscript_get_type', $original_properties_post->ID);
						foreach ($this_property_adscript_get_types as $this_property_adscript_get_type) {
							$this_property_headline .= ahc2015_adscript_link_html($this_property_adscript_get_type->ID) . " OR ";
						}
					} else {
						$type_field = get_field_object('unique_get_type', $original_properties_post->ID);
						$type_label = $type_field['choices'][ $this_property_type ];
						$this_property_headline .= $type_label . " OR ";
					}
				}
				$this_property_headline = rtrim($this_property_headline, " OR ") . "]";
			}
			if ($this_property_is_required_at_creation)
				$this_property_headline .= " <em>[required at creation]</em>";
			if ($this_property_can_be_a_number && $this_property_is_updatable)
				$this_property_headline .= " [tweenable]";
			if ($this_property_is_static)
				$this_property_headline .= " [static]";
			if ($this_property_is_read_only)
				$this_property_headline .= " [read-only]";
			else if (!$this_property_is_updatable)
				$this_property_headline .= " [cannot be updated]";

			if (!$this_property_is_required_at_creation)
			{
				$this_property_default_value = get_post_meta($original_properties_post->ID, "wpcf-default-value", true);
				$this_property_headline .= ' <i>| Default: ' . (empty($this_property_default_value) ? ahc2015_default_empty_value($this_property_types[0]) : $this_property_default_value) . "</i> ";
			}

			?>
			<h3 id="<?php echo $original_properties_post->post_title; ?>"><?php echo $this_property_headline; ?></h3>

			<?php echo $original_properties_post->post_content; ?>

			<?php 
			$code_example = get_post_meta($original_properties_post->ID, "wpcf-code-example", true);
			if (!empty($code_example))
			{?>
			<h4>Code Example</h4>
			<?php echo CrayonWP::highlight($code_example); 
			$first_item = false;
			}
		}
		?>

<?php 
		$original_methods_posts = ahc2015_original_methods( get_the_ID() );
		if (!empty($original_methods_posts)){?>
			<h2 id="methods-details">Method Details</h2>
		<?php 
		}
		$first_item = true;
		foreach ($original_methods_posts as $original_methods_post) {
			if (!$first_item)
			{
				?><hr/><?php
			}
			$this_method_params = ahc2015_method_params($original_methods_post->ID);
			$this_method_is_static = (get_post_meta($original_methods_post->ID, "wpcf-static", true) == 1);
			$this_method_headline = $original_methods_post->post_title;
			$this_method_headline .= "(";
			foreach ($this_method_params as $this_method_param) {
				$this_method_param_text = $this_method_param->post_title;

				$this_method_param_types = get_field('type', $this_method_param->ID);
				$this_method_param_types_text = "";
				foreach ($this_method_param_types as $this_method_param_type) {
					if ($this_method_param_type == "adscript"){
						$adscript_types = get_field('adscript_type', $this_method_param->ID);
						foreach ($adscript_types as $adscript_type) {
							$this_method_param_types_text .= ahc2015_adscript_link_html($adscript_type->ID) . " OR ";
						}
					} else {
						$this_method_param_type_field = get_field_object('type', $this_method_param->ID);
						$this_method_param_type_label = $this_method_param_type_field['choices'][ $this_method_param_type ];
						$this_method_param_types_text .= $this_method_param_type_label . " OR ";
					}
				}
				$this_method_param_types_text = rtrim($this_method_param_types_text, " OR ");
				$this_method_param_text .= ":" . $this_method_param_types_text;

				//$this_method_param->post_content
				
				$this_method_param_required = (get_post_meta($this_method_param->ID, "wpcf-is-required", true) == 1);
				if (!$this_method_param_required)
				{
					$this_method_param_default_value = get_post_meta($this_method_param->ID, "wpcf-default-value", true);
					$this_method_param_text .= ' = ' . (empty($this_method_param_default_value) ? ahc2015_default_empty_value($this_method_param_types[0]) : $this_method_param_default_value);
				}

				$this_method_headline .= $this_method_param_text;
				$this_method_headline .= ", ";
			}
			$this_method_headline = rtrim($this_method_headline, ", ") . ") : ";


			$return_types = get_field('return_type', $original_methods_post->ID);
			foreach ($return_types as $return_type) {
				if ($return_type == "adscript"){
					$adscript_return_types = get_field('adscript_return_type', $original_methods_post->ID);
					foreach ($adscript_return_types as $adscript_return_type) {
						$this_method_headline .= ahc2015_adscript_link_html($adscript_return_type->ID) . " OR ";
					}
				} else {
					$return_type_field = get_field_object('return_type', $original_methods_post->ID);
					$return_type_label = $return_type_field['choices'][ $return_type ];
					$this_method_headline .= $return_type_label . " OR ";
				}
			}
			$this_method_headline = rtrim($this_method_headline, " OR ");
			?>
			<h3 id="<?php echo $original_methods_post->post_title; ?>()"><?php echo $this_method_headline; ?></h3>
			<?php echo $original_methods_post->post_content; ?>
			<?php 

			if (count($this_method_params) > 0)
			{
			?>
				<h4>Parameters</h4>
				<ul><?php 
				foreach ($this_method_params as $this_method_param) {
					$this_method_param_text = $this_method_param->post_title;

					$this_method_param_types = get_field('type', $this_method_param->ID);
					$this_method_param_types_text = "";
					foreach ($this_method_param_types as $this_method_param_type) {
						if ($this_method_param_type == "adscript"){
							$adscript_types = get_field('adscript_type', $this_method_param->ID);
							foreach ($adscript_types as $adscript_type) {
								$this_method_param_types_text .= ahc2015_adscript_link_html($adscript_type->ID) . " OR ";
							}
						} else {
							$this_method_param_type_field = get_field_object('type', $this_method_param->ID);
							$this_method_param_type_label = $this_method_param_type_field['choices'][ $this_method_param_type ];
							$this_method_param_types_text .= $this_method_param_type_label . " OR ";
						}
					}
					$this_method_param_types_text = rtrim($this_method_param_types_text, " OR ");
					$this_method_param_text .= " : " . $this_method_param_types_text;

					$this_method_param_required = (get_post_meta($this_method_param->ID, "wpcf-is-required", true) == 1);
					if ($this_method_param_required)
					{
						//$this_method_param_text .= ' <strong>[required]</strong>';
					} else {
						$this_method_param_default_value = get_post_meta($this_method_param->ID, "wpcf-default-value", true);
						$this_method_param_text .= ' (default = ' . (empty($this_method_param_default_value) ? ahc2015_default_empty_value($this_method_param_types[0]) : $this_method_param_default_value) . ')';
					}
					$this_method_param_text .= '</br>';

					$this_method_param_text .= $this_method_param->post_content;

					//$this_method_headline .= $this_method_param_text;
					//$this_method_headline .= ", ";


					?>
					<li>
					<?php
					echo $this_method_param_text;
					$this_method_param_keys = ahc2015_method_param_keys($this_method_param->ID);
					if (!empty($this_method_param_keys))
					{
						?>
						<ul> <?php
						foreach ($this_method_param_keys as $this_method_param_key) {
							$this_method_param_key_text = $this_method_param_key->post_title;

							$this_method_param_key_types = get_field('type', $this_method_param_key->ID);
							$this_method_param_key_types_text = "";
							foreach ($this_method_param_key_types as $this_method_param_key_type) {
								if ($this_method_param_key_type == "adscript"){
									$adscript_types = get_field('adscript_type', $this_method_param_key->ID);
									foreach ($adscript_types as $adscript_type) {
										$this_method_param_key_types_text .= ahc2015_adscript_link_html($adscript_type->ID) . " OR ";
									}
								} else {
									$this_method_param_key_type_field = get_field_object('type', $this_method_param_key->ID);
									$this_method_param_key_type_label = $this_method_param_key_type_field['choices'][ $this_method_param_key_type ];
									$this_method_param_key_types_text .= $this_method_param_key_type_label . " OR ";
								}
							}
							$this_method_param_key_types_text = rtrim($this_method_param_key_types_text, " OR ");
							$this_method_param_key_text .= " : " . $this_method_param_key_types_text;

							$this_method_param_key_required = (get_post_meta($this_method_param_key->ID, "wpcf-is-required", true) == 1);
							if ($this_method_param_key_required)
							{
								$this_method_param_key_text .= ' <em>[required]</em>';
							} else {
								$this_method_param_key_default_value = get_post_meta($this_method_param_key->ID, "wpcf-default-value", true);
								$this_method_param_key_text .= ' = ' . (empty($this_method_param_key_default_value) ? ahc2015_default_empty_value($this_method_param_key_types[0]) : $this_method_param_key_default_value);
							}
							$this_method_param_key_text .= '</br>';

							$this_method_param_key_text .= $this_method_param_key->post_content;
							?>
							<li>
							<?php 
							echo $this_method_param_key_text;
							?>
							</li><?php 
						}
						?>
						</ul>
						<?php 
					}?>
					</li>
				<?php 
				} ?>
				</ul>
			<?php
			}
			$code_example = get_post_meta($original_methods_post->ID, "wpcf-code-example", true);
			if (!empty($code_example))
			{?>
			<h4>Code Example</h4>
			<?php echo CrayonWP::highlight($code_example); 
			$first_item = false;
			}
		}

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ahc2015' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php //ahc2015_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

