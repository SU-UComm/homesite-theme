<?php

/**
 * Template Name: Search Results - Accordion
 * Template Post Type: page, revision
 *
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package homesite-2017
 */

if (@$_REQUEST['search_type'] == 'people') {
  $url = "https://stanfordwho.stanford.edu/people?keyword=";
  $url .= urlencode($_REQUEST['q']);
  if (wp_redirect($url)) {
    exit;
  }
}

if (have_posts()) {
  the_post();

  get_header();

  $content = trim(get_the_content());
?>

  <main id="main" class="site-main" role="main">
    <h1 id="main-content" class="sr-only-element" tabindex="-1">Search Results</h1>

    <script type="text/javascript">
      //// TODO: revisit this JS code in the context of homesite17
      function startstate() {
        var searchBox = $('#gsc-i-id1'),
          len = searchBox.val().length;
        searchBox.focus();
        searchBox[0].setSelectionRange(0, len);
      }

      //// TODO: revisit this JS code in the context of homesite17
      function qs(el, type) {
        var qe = $('#gsc-i-id1').val();
        if (qe.length > 0) {
          if (type == 'who' || type == 'org') {
            el.href += "Search.do?search=";
            el.href += qe;
          } else if (type == 'map') {
            el.href += "?srch=";
            el.href += qe;
          }
        }
        return 1;
      }
    </script>

    <?php if (!empty($content)) { ?>
      <section class="search-feedback entry-content">
        <h2>
          <button class="form-toggle" aria-expanded="true" aria-controls="form_search-feedback">Help us improve your search experience<span class="sr-only-text">, click to close form</span></button>
        </h2>
        <?php the_content(); ?>
        <?php hs_render_panels('main'); ?>
      </section>
      <script>
        const outer = document.querySelector('.search-feedback');
        const button = document.querySelector('.form-toggle');
        const srText = document.querySelector('.form-toggle .sr-only-text')
        const form = document.getElementById('form_search-feedback');
        const formElements = form.querySelectorAll("input, select, textarea, button");
        const submit = document.querySelector('.frm_final_submit');

        // Execute form.timeout on page load.
        // form.timeout removes inline styles that force the form to display after 3 seconds.
        window.addEventListener('load', function() {

          form.timeout = setTimeout(function() {
            // Code to execute after the timeout
            form.removeAttribute('style');
            form.setAttribute('aria-hidden', 'true')
            button.setAttribute('aria-expanded', 'false');
            srText.textContent = "Click to open form"
          }, 3000);
        });

        // Clear form.timeout if any form element is focused.
        formElements.forEach(element => {
          element.addEventListener("focus", () => {
            clearTimeout(form.timeout);
          });
        });

        // All button click functions.
        function toggleElements() {
          form.removeAttribute('style');
          formHidden = form.getAttribute('aria-hidden') === 'true';
          form.setAttribute('aria-hidden', !formHidden);
          isExpanded = button.getAttribute('aria-expanded') === 'true';
          button.setAttribute('aria-expanded', !isExpanded);
          if (srText.textContent === "Click to close form") {
            srText.textContent = "Click to open form";
          } else {
            srText.textContent = "Click to close form";
          }
        };

        button.addEventListener("click", function() {
          toggleElements();
        });

        submit.addEventListener("click", function() {
          button.setAttribute("aria-hidden", "true");
        });
      </script>
      <!-- .entry-content -->
    <?php } ?>

    <section class="search-results">
      <script>
        (function($) {
          // Google Custom Search v2 no longer recognizes the as_sitesearch query parameter;
          // to limit results in v2 as_sitesearch must be an attribute of the <gcse:search> node.
          // So slap it on there if it's passed as a query parameter.
          if (location.search) {
            var site = location.search.match(/as_sitesearch=([^&]+)/);
            if (site) {
              var searchBox = jQuery('#gcse_search');
              searchBox.attr('as_sitesearch', site[1]);
            }
          }

          var cx = '006436690873851342600:mwjbvj5v0x0',
            gcse = document.createElement('script'),
            s = document.getElementsByTagName('script')[0];
          gcse.type = 'text/javascript';
          gcse.async = true;
          gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//cse.google.com/cse.js?cx=' + cx;
          s.parentNode.insertBefore(gcse, s);
        })(jQuery);
      </script>
      <gcse:searchresults-only></gcse:searchresults-only>
      <!-- <gcse:search enableAutoComplete="true"></gcse:search> -->
    </section>

  </main>

  <!-- #main -->

<?php
  get_footer();
} else {
  get_template_part('404');
}
