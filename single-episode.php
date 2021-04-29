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

        <section id="episoder">
            <template>
                <article>
                    <img class="single_episode" src="" alt="">
                    <div class="afsnit_navn">
                        <h2></h2>
                        <p class="beskrivelse"></p>
                    </div>
                </article>
            </template>

        </section>


    </main><!-- #main -->
    <script>
        let episoder;
        let episode;
        let aktuelpodcast;

        const episodeUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/episode?per_page=100";
        const dbUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/episode/" + <?php echo get_the_ID() ?>;

        const container = document.querySelector("#episoder");

        async function getJson() {
            console.log("getJson");
            const data = await fetch(dbUrl);
            episode = await data.json();
            aktuelpodcast = episode.horer_til_podcast;
            console.log(aktuelpodcast);

            const data2 = await fetch(episodeUrl);
            episoder = await data2.json();

            visEpisoder();
            visPodcasten();
        }

        function visEpisoder() {
            document.querySelector("h2").innerHTML = episode.title.rendered;
            document.querySelector(".pic").src = episode.billede.guid;
            document.querySelector(".beskrivelse").innerHTML = episode.beskrivelse;
            document.querySelector(".podcastnavn").innerHTML = episode.beliggenhed;
            document.querySelector(".udgivelsesdato").innerHTML = episode.udgivelsesdato;
            document.querySelector(".medvirkende").innerHTML = episode.medvirkende;

        }

        function visPodcasten() {
            console.log("visEpisode");
            let temp = document.querySelector("template");
            episoder.forEach(episode => {
                console.log("loop id :", aktuelpodcast);
                if (episode.horer_til_podcast == aktuelpodcast) {
                    console.log("loop kører id :", aktuelpodcast);
                    let klon = temp.cloneNode(true).content;
                    klon.querySelector("h2").innerHTML = episode.title.rendered;
                    klon.querySelector("img").src = episode.billede.guid;

                    //                    klon.querySelector(".beskrivelse").innerHTML = episode.beskrivelse;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = episode.link;
                    })
                    //                    klon.querySelector("a").href = episode.link;
                    console.log("episode", episode.link);
                    container.appendChild(klon);
                }
            })
        }


        getJson();

    </script>
</div><!-- #primary -->
<?php
get_footer();
