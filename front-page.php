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

<div class="afspiller_div">
    <div class="afspiller">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/afspiller.png" alt="afspilningsbar">
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

            <div class="knap_om_os">
                <a href="http://mathildesahlholdt.com/kea/sem2/09_cms/loud/om-loud/">
                    <button class="hoer_seneste semere_knap">Se mere</button></a>
            </div>
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
    let populaere = document.querySelector("#populaere"); //laver variabel 'populaere' som er vores section 'populære'
    let aktuelt = document.querySelector("#lydunivers #aktuelt"); //laver variabel 'aktuelt' som er vores section 'aktuelt'
    let satire = document.querySelector("#lydunivers #satire"); //laver variabel 'satire' som er vores section 'satire'
    let biografi = document.querySelector("#lydunivers #biografi"); //laver variabel 'biografi' som er vores section 'biografi'
    let podcaster; //laver variabel 'podcaster'

    let filterPodcast = "alle"; //laver variabel 'filterPodcast' som er lig med "alle"

    const dbUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/podcast?per_page=100"; //laver konstnat dbUrl som er lig med alle podcasts

    async function getJson() {
        console.log("getJson");
        const data = await fetch(dbUrl); //laver konstant 'data' som henter data via dbUrl variablen
        podcaster = await data.json(); //podcaster henter json data

        visPodcaster(); //Sætter funktionen visPodcaster igang

    }

    function visPodcaster() {
        let temp = document.querySelector("template"); //laver variabel 'temp' som er vores med template
        let container = document.querySelector(".episode_container"); //laver variabel container som er klassen .epi...

        container.innerHTML = ""; //fjerner indhold i containeren

        console.log(podcaster);
        podcaster.forEach(podcast => { //sætter forEach loop igang

            let klon = temp.cloneNode(true).content; //laver varianel 'klon' som får indsat indhold i template
            klon.querySelector("h4").innerHTML = podcast.title.rendered; //indsætter podcast-titlen i H4
            klon.querySelector("img").src = podcast.billede.guid; //indsætter billede

            klon.querySelector("article").addEventListener("click", () => { //Eventlistener click på hele article
                location.href = podcast.link; //og kommer videre til podcast singleview
            });
            if (podcast.genre.includes(parseInt(13))) { //hvis podcasten har genre-id'et 13 på sig
                populaere.appendChild(klon); //indsæt podcasten i section populaere
            }
            if (podcast.genre.includes(parseInt(14))) { //hvis podcasten har genre-id'et 14 på sig
                console.log("14", podcast.genre);
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h4").innerHTML = podcast.title.rendered;
                klon.querySelector("img").src = podcast.billede.guid;

                klon.querySelector("article").addEventListener("click", () => {
                    location.href = podcast.link;
                });

                aktuelt.appendChild(klon); //indsæt podcasten i section aktuelt

            };
            if (podcast.genre.includes(parseInt(12))) { //hvis podcasten har genre-id'et 12 på sig
                console.log("12", podcast);
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h4").innerHTML = podcast.title.rendered;
                klon.querySelector("img").src = podcast.billede.guid;

                klon.querySelector("article").addEventListener("click", () => {
                    location.href = podcast.link;
                });

                satire.appendChild(klon); //indsæt podcasten i section satire
            };
            if (podcast.genre.includes(parseInt(19))) { //hvis podcasten har genre-id'et 19 på sig
                console.log("19", podcast);
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h4").innerHTML = podcast.title.rendered;
                klon.querySelector("img").src = podcast.billede.guid;

                klon.querySelector("article").addEventListener("click", () => {
                    location.href = podcast.link;
                });

                biografi.appendChild(klon); //indsæt podcasten i section biografi
            }
        })
    }

    getJson(); //henter JSON data

</script>


<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
