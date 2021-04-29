<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
<div class="splash">
    <div class="overlay_2">

        <?php
        get_header();
        ?>



        <h1 class="lydfabrik">Danmarks <br> vildeste <br> lydfabrik</h1>

        <template>
            <article class="slide">
                <div class="hover_container aktuelt_container">
                    <img class="podcaster_img" src="" alt="">
                    <div class="overlay">
                        <h4></h4>
                        <p class="beskrivelse"></p>
                    </div>

                </div>
            </article>
        </template>


    </div>
</div>


<main id="site-content" role="main">
    <h2 class="popular_podcast">Populære podcasts</h2>
    <section id="populaere" class="episode_container slider"></section>
    <div class="knap_div">
        <a href="http://mathildesahlholdt.com/kea/sem2/09_cms/loud/podcaster/">
            <button class="hoer_seneste">Se mere</button> </a>
    </div>
    <section id="lydunivers">
        <h2 id="udforskLoudsLydunivers">Udforsk LOUDS lydunivers</h2>
        <h3>Aktuelle emner i samfundet</h3>
        <section id="aktuelt" class="episode_container slider"></section>
        <h3>Satire med et glimt i øjet</h3>
        <section id="satire" class="episode_container slider"></section>
        <h3>Spændende personligheder</h3>
        <section id="biografi" class="episode_container slider"></section>

    </section>


    <section id="hvem_er_loud">
        <div class="col">
            <h2>Hvem er LOUD?</h2>
            <h3 class="branchen">Branchen og pressen gravede vores grav - Nu sender vi fra dybet!</h3>

            <p>LOUD er en Lydfabrik, der skaber podcast og radio til de unge. Vi har haft en hård medfart, men det har gjort os endnu mere motiverede til at vise jer, at vi kan og vil skabe relevant indhold, som både er aktuelt og spændende. Læs mere om vores vision her.</p>
        </div>
        <div class="dybet"></div>
    </section>




    <?php

	$archive_title    = '';
	$archive_subtitle = '';

	if ( is_search() ) {
		global $wp_query;

		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="color-accent">' . __( 'Search:', 'twentytwenty' ) . '</span>',
			'&ldquo;' . get_search_query() . '&rdquo;'
		);

		if ( $wp_query->found_posts ) {
			$archive_subtitle = sprintf(
				/* translators: %s: Number of search results. */
				_n(
					'We found %s result for your search.',
					'We found %s results for your search.',
					$wp_query->found_posts,
					'twentytwenty'
				),
				number_format_i18n( $wp_query->found_posts )
			);
		} else {
			$archive_subtitle = __( 'We could not find any results for your search. You can give it another try through the search form below.', 'twentytwenty' );
		}
	} elseif ( is_archive() && ! have_posts() ) {
		$archive_title = __( 'Nothing Found', 'twentytwenty' );
	} elseif ( ! is_home() ) {
		$archive_title    = get_the_archive_title();
		$archive_subtitle = get_the_archive_description();
	}

	if ( $archive_title || $archive_subtitle ) {
		?>

    <header class="archive-header has-text-align-center header-footer-group">

        <div class="archive-header-inner section-inner medium">

            <?php if ( $archive_title ) { ?>
            <h1 class="archive-title"><?php echo wp_kses_post( $archive_title ); ?></h1>
            <?php } ?>

            <?php if ( $archive_subtitle ) { ?>
            <div class="archive-subtitle section-inner thin max-percentage intro-text"><?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?></div>
            <?php } ?>

        </div><!-- .archive-header-inner -->

    </header><!-- .archive-header -->

    <?php
	}

	if ( have_posts() ) {

		$i = 0;

		while ( have_posts() ) {
			$i++;
			if ( $i > 1 ) {
				echo '<hr class="post-separator styled-separator is-style-wide section-inner" aria-hidden="true" />';
			}
			the_post();

			get_template_part( 'template-parts/content', 'page' );

		}
	} elseif ( is_search() ) {
		?>

    <div class="no-search-results-form section-inner thin">

        <?php
			get_search_form(
				array(
					'label' => __( 'search again', 'twentytwenty' ),
				)
			);
			?>

    </div><!-- .no-search-results -->

    <?php
	}
	?>

    <?php get_template_part( 'template-parts/pagination' ); ?>

</main><!-- #site-content -->


<script>
    let populaere = document.querySelector("#populaere");
    let aktuelt = document.querySelector("#lydunivers #aktuelt");
    let satire = document.querySelector("#lydunivers #satire");
    let biografi = document.querySelector("#lydunivers #biografi");
    let podcaster;

    //    let genre;
    let filterPodcast = "alle";


    const dbUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/podcast?per_page=100";

    //    const genreUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/genre";

    async function getJson() {
        console.log("getJson");
        const data = await fetch(dbUrl);
        //        const genredata = await fetch(genreUrl);
        podcaster = await data.json();
        //        genre = await genredata.json();
        //        console.log(genre);
        visPodcaster();

    }




    function visPodcaster() {
        let temp = document.querySelector("template");
        let container = document.querySelector(".episode_container");


        container.innerHTML = "";

        console.log(podcaster);
        podcaster.forEach(podcast => {

            //            if (filterPodcast == "alle" || podcast.genre.includes(parseInt(filterPodcast))) {
            let klon = temp.cloneNode(true).content;
            klon.querySelector("h4").innerHTML = podcast.title.rendered;
            klon.querySelector("img").src = podcast.billede.guid;

            klon.querySelector("article").addEventListener("click", () => {
                location.href = podcast.link;
            });
            if (podcast.genre.includes(parseInt(13))) {
                populaere.appendChild(klon);
            }
            if (podcast.genre.includes(parseInt(14))) {
                console.log("14", podcast.genre);
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h4").innerHTML = podcast.title.rendered;
                klon.querySelector("img").src = podcast.billede.guid;

                klon.querySelector("article").addEventListener("click", () => {
                    location.href = podcast.link;
                });

                aktuelt.appendChild(klon);

                // aktuelt.innerHTML += "hej";
            };
            if (podcast.genre.includes(parseInt(12))) {
                console.log("12", podcast);
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h4").innerHTML = podcast.title.rendered;
                klon.querySelector("img").src = podcast.billede.guid;

                klon.querySelector("article").addEventListener("click", () => {
                    location.href = podcast.link;
                });

                satire.appendChild(klon);
            };
            if (podcast.genre.includes(parseInt(19))) {
                console.log("19", podcast);
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h4").innerHTML = podcast.title.rendered;
                klon.querySelector("img").src = podcast.billede.guid;

                klon.querySelector("article").addEventListener("click", () => {
                    location.href = podcast.link;
                });

                biografi.appendChild(klon);
            }
        })

    }

    //    else {
    // container.appendChild(klon);
    // }

    getJson();

</script>


<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
