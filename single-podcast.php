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
        <article>
            <img class="pic" src="" alt="">
            <div>
                <h2></h2>
                <p class="beskrivelse"></p>
            </div>
        </article>

        <section id="episode">
            <template>
                <article>
                    <img src="" alt="">
                    <div>
                        <h2></h2>
                        <p class="beskrivelse"></p>
                        <a href="">læs mere</a>
                    </div>
                </article>
            </template>
        </section>

    </main><!-- #main -->
    <script>
        let podcast;
        let episode;
        let aktuelpodcast = <?php echo get_the_ID() ?>;

        const dbUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/podcast/" + aktuelpodcast;
        const episodeURL = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/episode?per_page=100";

        const container = document.querySelector("#episode");

        async function getJson() {
            console.log("getJson");
            const data = await fetch(dbUrl);
            podcast = await data.json();
            console.log(podcast);

            const data2 = await fetch(episodeURL);
            episode = await data2.json();
            console.log("episode: ", episode)


            visPodcaster();
            visEpisode();
        }

        function visPodcaster() {
            console.log("visPodcaster")
            document.querySelector("h2").textContent = podcast.title.rendered;
            document.querySelector(".pic").src = podcast.billede.guid;
            document.querySelector(".beskrivelse").textContent = podcast.beskrivelse;

        }


        function visEpisode() {
            console.log("visEpisode");
            let temp = document.querySelector("template");
            episode.forEach(episode => {
                console.log("loop id :", aktuelpodcast);
                if (episode.horer_til_podcast == aktuelpodcast) {
                    console.log("loop kører id :", aktuelpodcast);
                    let klon = temp.cloneNode(true).content;
                    klon.querySelector("h2").textContent = episode.title.rendered;

                    klon.querySelector(".beskrivelse").innerHTML = episode.beskrivelse;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = episode.link;
                    })
                    klon.querySelector("a").href = episode.link;
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
