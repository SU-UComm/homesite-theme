<?php
class HS_Widget_Alert extends WP_Widget {

  public function __construct() {
    parent::__construct(
        'alert' // slug
      , __('Alert', 'stanford-text-domain') // name
      , [
            'description' => __( 'Display an alert at the top of every page.', 'stanford_text_domain' )
          , 'classname' => 'widget_alert'
        ]
      , [ 'width' => 450 ]
    );
  }

	/**
	 * Front-end display of widget
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     widget arguments
	 * @param array $instance saved values from database
	 */
	public function widget( $args, $instance ) {
    $theme    = empty( @$instance[ 'theme' ] ) ? 'alert-dark' : esc_attr( $instance[ 'theme' ] );
    $style    = empty( @$instance[ 'style' ] ) ? 'full'       : esc_attr( $instance[ 'style' ] );
    $icon     = empty( @$instance[ 'icon'  ] ) ? '' : '<span class="fa ' . esc_attr( trim( $instance[ 'icon' ] ) ) . '" aria-hidden="true"></span>';
    $headline = $icon . trim( $instance[ 'title' ] );
    $text     = trim( $instance[ 'text' ] );
    if ( ! empty( @$instance[ 'url' ] ) ) {
      $link_text = empty( @$instance[ 'link-text' ] ) ? $instance[ 'url' ] : $instance[ 'link-text' ];
      $link      = hs_shortcode_jump_link( [ 'url' => $instance[ 'url' ] ], $link_text );
      $text     .= $link; //// TODO: ' <a href="' . esc_attr( $instance[ 'url' ] ) . "\">{$link_text}</a>";
    }
    $text = apply_filters( 'the_content', $text );

    printf( $args[ 'before_widget' ], "theme--{$theme}" );
?>

  <figure data-style="<?php echo $style; ?>">
    <h2><?php echo $headline; ?></h2>
    <?php echo $text; ?>
  </figure><!-- Alert -->
  <button type="dismiss" data-ga-label="dismiss_alert"><span class="sr-only-text">Dismiss alert</span><span class="fa fa-times"></span></button>

<?php
    echo $args[ 'after_widget' ];
	}


	/**
	 * Back-end widget form
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance previously saved values from database
	 */
	public function form( $instance ) {
    $icon = [
        'id'    => $this->get_field_id(   "icon" )
      , 'name'  => $this->get_field_name( "icon" )
      , 'label' => __('<strong>Icon</strong>', 'stanford-text-domain')
      , 'value' => isset( $instance[ "icon" ] ) ? esc_attr( $instance[ "icon" ] ) : "fa-exclamation-triangle"
    ];

    $headline = [
        'id'    => $this->get_field_id(   "title" )
      , 'name'  => $this->get_field_name( "title" )
      , 'label' => __('<strong>Headline</strong>', 'stanford-text-domain' )
      , 'value' => isset( $instance[ "title" ] ) ? esc_attr( $instance[ "title" ] ) : "Alert"
    ];

    $text = [
        'id'    => $this->get_field_id(   "text" )
      , 'name'  => $this->get_field_name( "text" )
      , 'label' => __('<strong>Text</strong>', 'stanford-text-domain' )
      , 'value' => isset( $instance[ "text" ] ) ? esc_attr( $instance[ "text" ] ) : "Brief description of the situation."
    ];

    $url = [
        'id'    => $this->get_field_id(   "url" )
      , 'name'  => $this->get_field_name( "url" )
      , 'label' => __('<strong>Link - URL</strong>', 'stanford-text-domain' )
      , 'value' => isset( $instance[ "url" ] ) ? esc_attr( $instance[ "url" ] ) : "http://emergency.stanford.edu"
    ];

    $link_text = [
        'id'    => $this->get_field_id(   "link-text" )
      , 'name'  => $this->get_field_name( "link-text" )
      , 'label' => __('<strong>Link - Text</strong>', 'stanford-text-domain' )
      , 'value' => isset( $instance[ "link-text" ] ) ? esc_attr( $instance[ "link-text" ] ) : "More information"
    ];

    $style = [
        'id'      => $this->get_field_id(   "style" )
      , 'name'    => $this->get_field_name( "style" )
      , 'label'   => __('<strong>Style</strong>', 'stanford-text-domain' )
      , 'value'   => isset( $instance[ "style" ] ) ? esc_attr( $instance[ "style" ] ) : "full"
      , 'options' => [ 'compact' => 'Compact', 'full' => 'Full' ]
    ];

    $theme = [
        'id'      => $this->get_field_id(   "theme" )
      , 'name'    => $this->get_field_name( "theme" )
      , 'label'   => __('<strong>Color</strong>', 'stanford-text-domain' )
      , 'value'   => isset( $instance[ "theme" ] ) ? esc_attr( $instance[ "theme" ] ) : "alert-dark"
      , 'options' => [
            'alert-dark'     => 'Alert - Dark'
          , 'alert-light'    => 'Alert - Light'
          , 'announce-dark'  => 'Announce - Dark'
          , 'announce-light' => 'Announce - Light'
        ]
    ];

?>
    <p>
      <label for="<?php echo $icon[ 'id' ]; ?>"><?php echo $icon[ 'label' ]; ?></label><br/>
      <input class="info_box_widget_icon" style="width:60%;"
             id="<?php echo $icon[ 'id' ]; ?>"
             name="<?php echo $icon[ 'name' ]; ?>"
             type="text"
             value="<?php echo $icon[ 'value' ]; ?>"
             />
      &nbsp;
      <span class="fa <?php echo $icon[ 'value' ]; ?> fa-2x"></span>
      <br/>&nbsp;<em>See <a href="http://fontawesome.io/icons/" target="_blank">Font Awesome icons</a> for valid icons.</em>
    </p>

    <p>
      <label for="<?php echo $headline[ 'id' ]; ?>"><?php echo $headline[ 'label' ]; ?></label><br/>
      <input class="info_box_widget_headline widefat"
             id="<?php echo $headline[ 'id' ]; ?>"
             name="<?php echo $headline[ 'name' ]; ?>"
             type="text"
             value="<?php echo $headline[ 'value' ]; ?>"
             />
    </p>

    <p>
      <label for="<?php echo $text[ 'id' ]; ?>"><?php echo $text[ 'label' ]; ?></label>
      <textarea class="widefat"
             id="<?php echo $text[ 'id' ]; ?>"
             name="<?php echo $text[ 'name' ]; ?>"
             rows="6"
             ><?php echo $text[ 'value' ]; ?></textarea>
    </p>

    <p>
      <label for="<?php echo $url[ 'id' ]; ?>"><?php echo $url[ 'label' ]; ?></label><br/>
      <input class="info_box_widget_link_url widefat"
             id="<?php echo $url[ 'id' ]; ?>"
             name="<?php echo $url[ 'name' ]; ?>"
             type="text"
             value="<?php echo $url[ 'value' ]; ?>"
      />
    </p>

    <p>
      <label for="<?php echo $link_text[ 'id' ]; ?>"><?php echo $link_text[ 'label' ]; ?></label><br/>
      <input class="info_box_widget_link_text widefat"
             id="<?php echo $link_text[ 'id' ]; ?>"
             name="<?php echo $link_text[ 'name' ]; ?>"
             type="text"
             value="<?php echo $link_text[ 'value' ]; ?>"
      />
    </p>

    <p>
      <label for="<?php echo $theme[ 'id' ]; ?>"><?php echo $theme[ 'label' ]; ?></label><br/>
      <?php foreach ( $theme[ 'options' ] as $value => $label ) { ?>
        <input id="<?php echo $theme[ 'id' ]; ?>"
               name="<?php echo $theme[ 'name' ]; ?>"
               type="radio"
               value="<?php echo $value; ?>"
            <?php if ( $value == $theme[ 'value' ] ) echo "checked=\"checked\"" ?>
        /> <?php echo $label; ?><br/>
      <?php } ?>
    </p>

    <p>
      <label for="<?php echo $style[ 'id' ]; ?>"><?php echo $style[ 'label' ]; ?></label><br/>
      <?php foreach ( $style[ 'options' ] as $value => $label ) { ?>
        <input id="<?php echo $style[ 'id' ]; ?>"
               name="<?php echo $style[ 'name' ]; ?>"
               type="radio"
               value="<?php echo $value; ?>"
            <?php if ( $value == $style[ 'value' ] ) echo "checked=\"checked\"" ?>
        /> <?php echo $label; ?><br/>
      <?php } ?>
    </p>
<?php
	}

	/**
	 * Sanitize widget form values as they are saved
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved
	 * @param array $old_instance Previously saved values from database
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = [
		    'style'     => sanitize_text_field( trim( $new_instance[ 'style' ] ) )
		  , 'icon'      => sanitize_text_field( trim( $new_instance[ 'icon'  ] ) )
      , 'title'     => sanitize_text_field( trim( $new_instance[ 'title' ] ) )
      , 'text'      => wp_kses_post( trim( $new_instance[ 'text' ] ) )
      , 'url'       => esc_url_raw( trim( $new_instance[ 'url' ] ), [ 'http', 'https' ] )
      , 'link-text' => sanitize_text_field( trim( $new_instance[ 'link-text' ] ) )
      , 'theme'     => sanitize_text_field( trim( $new_instance[ 'theme' ] ) )
    ];

		return $instance;
	}
}