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
            <img class="pic" src="" alt="">
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
            document.querySelector("h2").textContent = episode.title.rendered;
            document.querySelector(".pic").src = episode.billede.guid;
            document.querySelector(".beskrivelse").textContent = episode.beskrivelse;
            document.querySelector(".podcastnavn").textContent = episode.beliggenhed;
            document.querySelector(".udgivelsesdato").textContent = episode.udgivelsesdato;
            document.querySelector(".medvirkende").textContent = episode.medvirkende;

        }

        getJson();

    </script>
</div><!-- #primary -->
<?php
get_footer();
