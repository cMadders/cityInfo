<?php
function spintech_info_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Info  Section
	=========================================*/
	$wp_customize->add_section(
		'info_setting', array(
			'title' => esc_html__( 'Info Section', 'spintech' ),
			'priority' => 3,
			'panel' => 'spintech_frontpage_sections',
		)
	);

	// Info content Section // 
	
	$wp_customize->add_setting(
		'info_content_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'spintech_sanitize_text',
			'priority' => 7,
		)
	);

	$wp_customize->add_control(
	'info_content_head',
		array(
			'type' => 'hidden',
			'label' => __('Content','spintech'),
			'section' => 'info_setting',
		)
	);
	
	/**
	 * Customizer Repeater for add info
	 */
	
		$wp_customize->add_setting( 'info_contents', 
			array(
			 'sanitize_callback' => 'burger_companion_repeater_sanitize',
			 'transport'         => $selective_refresh,
			 'priority' => 8,
			 'default' => spintech_get_info_default()
			)
		);
		
		$wp_customize->add_control( 
			new Burger_Companion_Repeater( $wp_customize, 
				'info_contents', 
					array(
						'label'   => esc_html__('Information','spintech'),
						'section' => 'info_setting',
						'add_field_label'                   => esc_html__( 'Add New Information', 'spintech' ),
						'item_name'                         => esc_html__( 'Information', 'spintech' ),
						'customizer_repeater_icon_control' => true,
						'customizer_repeater_title_control' => true,
						'customizer_repeater_text_control' => true,
					) 
				) 
			);
			
		//Pro feature
		class Spintech_info_section_upgrade extends WP_Customize_Control {
			public function render_content() { 
			?>
				<a class="customizer_spintech_info_upgrade_section up-to-pro"  href="https://burgerthemes.com/downloads/spintech-pro/" target="_blank" style="display: none;"><?php _e('More Info Available in Spintech Pro','spintech'); ?></a>
			<?php
			}
		}
		
		$wp_customize->add_setting( 'spintech_info_upgrade_to_pro', array(
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Spintech_info_section_upgrade(
			$wp_customize,
			'spintech_info_upgrade_to_pro',
				array(
					'section'				=> 'info_setting',
				)
			)
		);
}

add_action( 'customize_register', 'spintech_info_setting' );

// info selective refresh
function spintech_home_info_section_partials( $wp_customize ){	
	// info content
	$wp_customize->selective_refresh->add_partial( 'info_contents', array(
		'selector'            => '.info-section .info-wrapper'
	
	) );
	
	}

add_action( 'customize_register', 'spintech_home_info_section_partials' );