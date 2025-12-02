<?php wp_footer(); ?>
<footer class="mt-half">
    <nav>
        <?php wp_nav_menu([
          "theme_location" => "footerMenuLocation",
        ]); ?>
    </nav>
</footer>
<!-- Searcb popup -->
<div id="search-overlay" class="search-overlay" aria-expanded="false">
    <div class="content">
        <div class="search-overlay__content search-overlay__top">
            <h2>Search</h2>
        </div>
        <div class="search-overlay__content search-overlay__main p-1">
            <div class="fx-row-center gap-1 w100">
                <input type="text" class="search-term" id="search-term" placeholder="Keyword" aria-hidden="true">
                <button type="submit"
                    class="btn btn__icon text-xl fx-content-center p-r1 rounded-sm"><?php generate_icon("search") ?></button>
            </div>
        </div>
        <div class="search-overlay__content search-overlay__bottom"></div>
    </div>
    <div class="close__wrapper" id="close-search-overlay"><span class="close__button"
            aria-label="close search search-overlay"></span></div>
</div>
</body>

</html>