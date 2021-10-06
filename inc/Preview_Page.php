<?php

namespace Stanford\Homesite;

class Preview_Page {

  /** @var Preview_Page singleton instance of this class */
  protected static $instance = null;

  /** @var string the template file used by the (normal) homepage and the preview page */
  const HOMEPAGE_TEMPLATE = 'homepage.php';

  /** @var string the template file used by the emergency homepage */
  const EMERGENCY_PAGE_TEMPLATE = 'emergency-page.php';

  /** @var string slug of the metabox that contains Do Not Edit Homepage message */
  const DONT_EDIT_METABOX_SLUG = 'dont-edit';

  /** @var string slug of the metabox that contains the copy buttons */
  const COPY_METABOX_SLUG = 'copy-buttons';

  /** @var string slug of the metabox that contains the copy buttons */
  const HOMPAGE_WARNING_METABOX_SLUG = 'hp-warning';


  /**
   * Preview_Page constructor
   * add the appropriate actions / filters
   */
  public function __construct( ) {
    add_action( 'add_meta_boxes',   [ $this, 'add_metaboxes'          ] );
    add_action( 'wp_ajax_copypost', [ $this, 'admin_ajax_copy_post'   ] );
  }

  /**
   * Add our custom metaboxes as appropriate.
   * Invoked via the add_meta_boxes action.
   */
  public function add_metaboxes() {
    global $post;

    $template    = get_page_template_slug( $post->ID );
    $homepage_id = get_option( 'page_on_front' );
    $hp_template = get_page_template_slug( $homepage_id );

    // if the homepage's page template isn't set properly, warn the user
    if ( empty( $hp_template ) ) {
      add_meta_box(
          self::HOMPAGE_WARNING_METABOX_SLUG
          , 'ERROR ON HOMPAGE'
          , [ $this, 'render_hp_warning' ]
          , 'page'
          , 'side'
          , 'high'
      );
    }

    if ( $post->ID == $homepage_id && $template == self::HOMEPAGE_TEMPLATE ) {
      add_meta_box(
          self::DONT_EDIT_METABOX_SLUG
          , 'DO NOT EDIT HOMEPAGE'
          , [ $this, 'render_dont_edit' ]
          , 'page'
          , 'side'
          , 'high'
      );
    }

    // only display the copy buttons metabox on the Preview Homepage page
    if ( $template == self::HOMEPAGE_TEMPLATE && preg_match( '/[Pp]review/', $post->post_title ) ) {
      add_meta_box(
          self::COPY_METABOX_SLUG
        , 'Update Homepage'
        , [ $this, 'render_copy_buttons' ]
        , 'page'
        , 'side'
        , 'high'
      );
    }
  }

  /**
   * Render the content of the metabox that warns the user not to edit the homepage directly.
   * Invoked as a callback registered via the call to add_meta_box().
   *
   * @param \WP_Post $page the page we're editing - should only be the Preview page (see maybe_suppress_metabox())
   * @param array $args unused
   */
  public function render_dont_edit( $page, $args ) {
    $id = $page->ID;
?>
      <h2>WARNING</h2>
  <p>
    You are editing the homepage directly. You should not do this.
    Please edit the <strong>AAA - Preview Homepage</strong> and use the <strong>Copy preview to live</strong>
    button to update the homepage.
  </p>
<?php
  }

  /**
   * Render the content of the metabox with the copy button(s).
   * Invoked as a callback registered via the call to add_meta_box().
   *
   * @param \WP_Post $page the page we're editing - should only be the Preview page (see maybe_suppress_metabox())
   * @param array $args unused
   */
  public function render_copy_buttons( $page, $args ) {
    $id = $page->ID;
?>
  <a id="copyp2l" data-page-id="<?php echo $id; ?>" class="button" href="#">Copy preview to live</a>
<?php
  }

  /**
   * Render the content of the metabox that warns the user if the homepage's page template is messed up.
   * Invoked as a callback registered via the call to add_meta_box().
   *
   * @param \WP_Post $page the page we're editing - should only be the Preview page (see maybe_suppress_metabox())
   * @param array $args unused
   */
  public function render_hp_warning( $page, $args ) {
    $id = $page->ID;
    ?>
    <h2>WARNING</h2>
    <p>
      The page template on the homepage is not set properly. Please edit the homepage and set its page template
      to either "Home Page" or "Emergency Page", as appropriate.
    </p>
    <?php
  }

  /**
   * Actually do the copy from preview to live, or from live to preview.
   * Invoked via AJAX and the wp_ajax_copypost action.
   *
   * @return JSON data specifying success or fail, and a message to show to the user.
   */
  public function admin_ajax_copy_post() {
    $valid = check_ajax_referer('homesite17-admin-js', 'hs_nonce', FALSE);
    if ( $valid === FALSE ) {
      $result = array(
          'status'  => 'fail'
        , 'message' => "Invalid nonce {$_REQUEST[ 'hs_nonce' ]}"
      );
      echo json_encode($result);
      wp_die(); // this is AJAX request, so prevent any additional processing
    }

    if ( current_user_can('edit_others_pages') ) {

      // validate that the current homepage exists and is the normal homepage (not, e.g., the emergency homepage)
      $homepage_id = get_option( 'page_on_front' );
      $homepage    = get_post( $homepage_id  );
      if ( !is_a( $homepage, 'WP_Post' ) || $homepage->post_type != 'page' ) {
        $result = [
            'status'  => "fail"
          , 'message' => "The current homepage, {$homepage_id}, is not a page."
        ];
      } else {
        $template = get_page_template_slug( $homepage_id );
        if ( $template != self::HOMEPAGE_TEMPLATE ) {
          $result = [
              'status'  => "fail"
            , 'message' => "The current homepage, {$homepage_id}, does not use the homepage template, " . self::HOMEPAGE_TEMPLATE . "."
          ];
        }
      }

      // validate the preview page id (passed in via the AJAX request, for convenience) corresponds to a post that uses the homepage template
      $prev_page_id = intval( $_REQUEST[ 'page' ] );
      $preview_page = get_post( $prev_page_id );
      if ( !is_a( $preview_page, 'WP_Post' ) || $preview_page->post_type != 'page' ) {
        $result = [
            'status'  => "fail"
          , 'message' => "The specified preview page, {$prev_page_id}, is not a page."
        ];
      } else {
        $template = get_page_template_slug( $prev_page_id );
        if ( $template != self::HOMEPAGE_TEMPLATE ) {
          $result = [
              'status'  => "fail"
            , 'message' => "The specified preview page, {$prev_page_id}, does not use the homepage template, " . self::HOMEPAGE_TEMPLATE . "."
          ];
        }
      }

      // if we haven't already set an error message, then actually do the copy
      if ( !isset( $result ) ) {
        $action = sanitize_text_field( $_REQUEST[ 'do' ] );
        switch ( $action ) {
          case 'copyl2p':
            $preview_page->post_content_filtered = $homepage->post_content_filtered; // panels are stored in post_content_filtered
            $status = wp_update_post( $preview_page ); // save the preview page
            if ( $status == $prev_page_id ) {
              $result = [
                  'status'  => 'success'
                , 'message' => "The preview page has been updated."
              ];
            } else {
              $result = [
                  'status'  => 'fail'
                , 'message' => "Unable to update the preview page."
              ];
            }
            break;
          case 'copyp2l':
            $homepage->post_content_filtered = $preview_page->post_content_filtered; // panels are stored in post_content_filtered
            $status = wp_update_post( $homepage ); // save the homepage
            if ( $status == $homepage_id ) {
              $result = [
                  'status'  => 'success'
                , 'message' => "The homepage has been updated."
              ];
            } else {
              $result = [
                  'status'  => 'fail'
                , 'message' => "Unable to update the homepage."
              ];
            }
            break;
          default:
            $result = [
                'status'  => "fail"
              , 'message' => "Invalid operation specified: {$action}"
            ];
            break;
        }
      }
    } else {
      $result = array(
          'status'   => 'fail'
        , 'message'  => "You are not authorized to perform this action."
      );
    }

    // return the result
    echo json_encode($result);
    wp_die(); // this is AJAX request, so prevent any additional processing
  }

  /**
   * Create singleton instance, if necessary.
   *
   * @param string $plugin_file full path to plugin's main file
   */
  public static function init() {
    if ( !is_a( self::$instance, __CLASS__ ) ) {
      self::$instance = new Preview_Page();
    }
    return self::$instance;
  }
}

Preview_Page::init();