<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <article class="single_episode_article">
            <div class="single_col">
                <img class="pic" src="" alt="">
                <div class="lytmedher">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/svg/loud.svg">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/svg/googlepodcast.svg">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/svg/podcastplayer.svg">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/svg/spotify.svg">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/svg/podimo.svg">
                </div>
            </div>
            <div class="single_episode_div">
                <h2></h2>
                <p class="beskrivelse"></p>
                <p class="podcastnavn"></p>
                <p class="udgivelsesdato"></p>
                <p class="medvirkende"></p>
            </div>
        </article>

    </main><!-- #main -->
    <script>
        let episode;

        const dbUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/episode/" + <?php echo get_the_ID() ?>;

        async function getJson() {
            console.log("getJson");
            const data = await fetch(dbUrl);
            episode = await data.json();
            console.log(episode);
            visEpisoder();
        }

        function visEpisoder() {
            document.querySelector("h2").innerHTML = episode.title.rendered;
            document.querySelector(".pic").src = episode.billede.guid;
            document.querySelector(".beskrivelse").innerHTML = episode.beskrivelse;
            document.querySelector(".podcastnavn").innerHTML = episode.beliggenhed;
            document.querySelector(".udgivelsesdato").innerHTML = episode.udgivelsesdato;
            document.querySelector(".medvirkende").innerHTML = episode.medvirkende;

        }

        getJson();

    </script>
</div><!-- #primary -->
<?php
get_footer();
