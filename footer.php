<?php
/**
 * The template for displaying the footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package homesite-2017
 */

?>
<footer data-ga-category="Footer">
  <?php hs_render_panels( 'footer' ); ?>
  <section id="footer__pre-footer" data-ga-action="Pre-footer">
    <div class="social">
      <ul data-ga-action="Social media">
        <?php
        hs_social_icon( 'Facebook', 'fa-facebook-square' );
        hs_social_icon( 'Twitter', 'fa-twitter' );
        hs_social_icon( 'Instagram', 'fa-instagram' );
        hs_social_icon( 'YouTube', 'fa-youtube-play' );
        hs_social_icon( 'iTunes U', 'fa-apple' );
        ?>
      </ul>
    </div>
  </section>

  <section id="footer__content" data-ga-action="Fat footer">
    <div>
      <div>
        <div>
          <h3>Schools</h3>
          <ul>
            <li><a href="https://www.gsb.stanford.edu/">Business</a></li>
            <li><a href="https://earth.stanford.edu/">Earth, Energy & Environmental Sciences</a></li>
            <li><a href="https://ed.stanford.edu/">Education</a></li>
            <li><a href="https://engineering.stanford.edu/">Engineering</a></li>
            <li><a href="https://humsci.stanford.edu/">Humanities & Sciences</a></li>
            <li><a href="https://law.stanford.edu/">Law</a></li>
            <li><a href="https://med.stanford.edu/">Medicine</a></li>
          </ul>
        </div>
        <div>
          <h3>Departments</h3>
          <ul>
            <li><a href="/list/academic/">Departments A&nbsp;<span aria-hidden="true">-</span><span class="sr-only-text"> to </span>&nbsp;Z</a></li>
            <li><a href="/list/interdisc/">Interdisciplinary Programs</a></li>
          </ul>
          <h3>Research</h3>
          <ul>
            <li><a href="/list/research/">Research Centers A&nbsp;<span aria-hidden="true">-</span><span class="sr-only-text"> to </span>&nbsp;Z</a></li>
            <li><a href="https://interdisciplinary.stanford.edu/">Interdisciplinary Research</a></li>
            <li><a href="http://library.stanford.edu/">Libraries</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div>
      <div>
        <div>
          <h3>Health Care</h3>
          <ul>
            <li><a href="https://stanfordhealthcare.org/">Stanford Health Care</a></li>
            <li><a href="https://www.stanfordchildrens.org/">Stanford Children's Health</a></li>
          </ul>
          <h3>Online Learning</h3>
          <ul>
            <li><a href="https://online.stanford.edu/">Stanford Online</a></li>
          </ul>
        </div>
        <div>
          <h3>About Stanford</h3>
          <ul>
            <li><a href="https://facts.stanford.edu/">Facts</a></li>
            <li><a href="/about/history">History</a></li>
            <li><a href="https://wasc.stanford.edu/">Accreditation</a></li>
          </ul>
          <h3>Admission</h3>
          <ul>
            <li><a href="https://admission.stanford.edu/">Undergraduate</a></li>
            <li><a href="https://gradadmissions.stanford.edu">Graduate</a></li>
            <li><a href="https://financialaid.stanford.edu/">Financial Aid</a></li>
          </ul>
        </div>
        <div>
          <h3>Resources</h3>
          <ul>
            <li><a href="/atoz/">A&nbsp;<span aria-hidden="true">-</span><span class="sr-only-text"> to </span>&nbsp;Z Index</a></li>
            <li><a href="https://campus-map.stanford.edu/">Campus Map</a></li>
            <li><a href="https://community.stanford.edu/">Community Engagement</a></li>
            <li><a href="https://stanfordwho.stanford.edu/">Directory</a></li>
            <li><a href="https://profiles.stanford.edu/">Stanford Profiles</a></li>
          </ul>
        </div>
      </div>
    </div>
    <ul class="connect">
      <li><a href="/admission">Applying</a></li>
      <li><a href="https://visit.stanford.edu/">Visiting</a></li>
      <li><a href="https://giving.stanford.edu/">Giving</a></li>
      <li><a href="https://stanfordcareers.stanford.edu/">Careers</a></li>
      <li><a href="/contact">Contact</a></li>
    </ul>
  </section>

  <section id="footer__global-footer" data-ga-action="Global footer">
    <div id="global-footer__brand">
      <a href="/" class="su-brand">Stanford<br />University</a>
    </div>
    <nav id="global-footer__nav" aria-label="global footer menu">
      <ul id="global-links">
        <li><a href="/">Stanford Home</a></li>
        <li><a href="https://visit.stanford.edu/plan/">Maps &amp; Directions</a></li>
        <li><a href="/search/">Search Stanford</a></li>
        <li><a href="https://emergency.stanford.edu/">Emergency Info</a></li>
      </ul>
      <ul id="global-policy-links">
        <li><a href="/site/terms/" title="Terms of use for sites">Terms of Use</a></li>
        <li><a href="/site/privacy" title="Privacy and cookie policy">Privacy</a></li>
        <li><a href="https://uit.stanford.edu/security/copyright-infringement" title="Report alleged copyright infringement">Copyright</a></li>
        <li><a href="https://adminguide.stanford.edu/chapter-1/subchapter-5/policy-1-5-4" title="Ownership and use of Stanford trademarks and images">Trademarks</a></li>
        <li><a href="https://exploredegrees.stanford.edu/nonacademicregulations/nondiscrimination/" title="Non-discrimination policy">Non-Discrimination</a></li>
        <li><a href="/site/accessibility/" title="Report web accessibility issues">Accessibility</a></li>
      </ul>
    </nav>
    <div id="global-footer__info">
      <p class="vcard"><span aria-hidden="true">©</span><span class="sr-only-text">Copyright </span>
        <span class="fn org">Stanford University</span>. &nbsp;
        <span class="adr">
          <span class="locality">Stanford</span>,
          <span class="region">California</span>
          <span class="postal-code">94305</span>.</span>
      </p>
    </div>
  </section>
</footer>

<?php wp_footer(); ?>

</body>
</html>
