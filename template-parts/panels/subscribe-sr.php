<?php
$panel_vars = get_panel_vars();

$btn_text = esc_attr( $panel_vars[ 'btn_text' ] );

hs_panel_header( $panel_vars );

?>

  <form action="https://stanford.us5.list-manage.com/subscribe/post?u=a8e6569da943904e9ac369cde&amp;id=29ce9f751e" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank" class="validate" novalidate="">
    <div class="input-wrapper">
      <label for="mce-EMAIL" aria-hidden="true"><span class="fa fa-arrow-circle-o-down" aria-hidden="true" role="presentation"></span>Enter your email address below</label>
      <span class="fa fa-envelope" aria-hidden="true" role="presentation"></span>
      <input type="email" name="EMAIL" id="mce-EMAIL" placeholder="Enter your email address" />
    </div>
    <input type="submit" value="<?php echo $btn_text; ?>" name="subscribe" id="mc-embedded-subscribe" />
  </form>

<?php

hs_panel_footer( $panel_vars );