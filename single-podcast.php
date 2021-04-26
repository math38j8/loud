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
        <article class="single_article">
            <img class="single_pic" src="" alt="">
            <div class="single_tekst">
                <h2></h2>
                <p class="beskrivelse"></p>
                <p class="genre"></p>
            </div>
            <button class="hoer_seneste">Hør seneste afsnit</button>

        </article>

        <section id="lytmedher">
            <h3>Lyt med her!</h3>
            <div class="lytmedher">
                <img src="svg/loud.svg">
                <img src="svg/googlepodcast.svg">
                <img src="svg/podcastplayer.svg">
                <img src="svg/spotify.svg">
                <img src="svg/podimo.svg">
            </div>
        </section>

        <section id="episode">
            <h4>Alle afsnit af</h4>
            <p>APRIL 2021</p>
            <template>
                <article class="single_podcast">
                    <img src="" alt="">
                    <div>
                        <h2></h2>
                        <p class="beskrivelse"></p>
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
            document.querySelector(".single_pic").src = podcast.billede.guid;
            document.querySelector(".beskrivelse").textContent = podcast.beskrivelse;
            document.querySelector(".genre").textContent = podcast.genre;

        }


        function visEpisode() {
            console.log("visEpisode");
            let temp = document.querySelector("template");
            episode.forEach(episode => {
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
