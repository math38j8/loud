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
?>
<div class="podcast_splash">
    <div class="overlay_2">


        <?php
get_header();
?>
        <h1 class="lydfabrik">Udforsk <br> LOUDS <br> lydunivers</h1>

        <template>
            <article class="slide">
                <div class="hover_container">
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
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/afspiller.png">
    </div>
</div>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <!--        <div class="singular-content-wrap">-->

        <section id="groen">
            <h3>Seneste episoder</h3>
            <section class="seneste_epis  slider"></section>
        </section>
        <!--
        <section id="popular">
            <h3>Populære podcasts</h3>
            <section id="populaere episode_container slider"></section>
        </section>
-->

        <h3>Lyt til</h3>
        <div class="filtreringsknap">
            <button class="filtrer">Filtrer</button>
        </div>
        <nav id="filtrering"><button class="filter_button" data-episode="alle">Alle</button></nav>
        <section id="udforsk" class="episode_container slider">

        </section>

        <!--        </div>  .singular-content-wrap -->
    </main><!-- #main -->

    <script>
        window.addEventListener('DOMContentLoaded', sidenVises);





        let episoder;
        let podcaster;
        let categories;
        let filterPodcast = "alle";

        const episodeUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/episode?per_page=100";
        const dbUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/podcast?per_page=100";
        const catUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/genre";

        async function getJson() {
            console.log("getJson");
            const data = await fetch(dbUrl);
            const catdata = await fetch(catUrl);
            const epidata = await fetch(episodeUrl);
            episoder = await epidata.json();
            podcaster = await data.json();
            categories = await catdata.json();
            console.log(categories);
            visEpisoder();
            visPodcaster();
            opretKnapper();

        }

        function opretKnapper() {
            categories.forEach(cat => {
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-podcast="${cat.id}">${cat.name}</button>`
            })

            addEventListenersToButtons();
        }

        function addEventListenersToButtons() {
            document.querySelectorAll("#filtrering button").forEach(elm => {
                elm.addEventListener("click", filtrering);
            })
        }

        function filtrering() {
            filterPodcast = this.dataset.podcast;
            console.log("filterPodcast", filterPodcast);

            visPodcaster();
        }

        function sidenVises() {
            console.log("siden vises");
            document.querySelector("#filtrering").classList.add("hide");
            document.querySelector(".filtrer").addEventListener("click", visFiltrer);
        }

        function visFiltrer() {
            console.log("vis filtrer");
            document.querySelector("#filtrering").classList.toggle("hide");

        }

        function visEpisoder() {
            let temp = document.querySelector("template");
            let episode_container = document.querySelector(".seneste_epis");
            episode_container.innerHTML = "";
            episoder.forEach(episode => {
                if (episode.seneste == 1) {
                    console.log(episode.seneste);
                    let klon = temp.cloneNode(true).content;
                    klon.querySelector("h4").innerHTML = episode.title.rendered;
                    klon.querySelector("img").src = episode.billede.guid;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = episode.link;
                    })
                    episode_container.appendChild(klon);
                }

            })
        }

        function visPodcaster() {
            let temp = document.querySelector("template");
            let container = document.querySelector("#udforsk");
            container.innerHTML = "";
            podcaster.forEach(podcast => {
                console.log("podcast.genre", podcast.genre);
                if (filterPodcast == "alle" || podcast.genre.includes(parseInt(filterPodcast))) {
                    let klon = temp.cloneNode(true).content;
                    klon.querySelector("h4").textContent = podcast.title.rendered;
                    klon.querySelector("img").src = podcast.billede.guid;
                    // klon.querySelector(".beskrivelse").textContent = podcast.beskrivelse;
                    // klon.querySelector(".podcastnavn").textContent = episode.podcastnavn;
                    // klon.querySelector(".udgivelsesdato").textContent = episode.udgivelsesdato;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = podcast.link;
                    })
                    container.appendChild(klon);
                }

            })
        }





        getJson();

    </script>



</div><!-- #primary -->

<?php
get_footer();
