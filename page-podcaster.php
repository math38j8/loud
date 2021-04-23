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
                        <h2></h2>
                        <p class="beskrivelse"></p>
                    </div>

                </div>
            </article>
        </template>


    </div>
</div>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <!--        <div class="singular-content-wrap">-->

        <!--        <nav id="filtrering"><button data-episode="alle">Alle</button></nav>-->
        <section id="groen">
            <h3>Seneste episoder</h3>
            <section class="podcast_container slider"></section>
        </section>
        <section id="popular">
            <h3>Populære podcasts</h3>
        </section>
        <section id="udforsk">
            <h3>Udforsk LOUDS lydunivers</h3>
            <h3>Satire med et glimt i øjet</h3>
            <h3>Spændende personligheder</h3>
        </section>

        <!--        </div>  .singular-content-wrap -->
    </main><!-- #main -->

    <script>
        let podcaster;
        let categories;
        let filterPodcast = "alle";

        const dbUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/podcast?per_page=100";
        const catUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/categories";

        async function getJson() {
            console.log("getJson");
            const data = await fetch(dbUrl);
            const catdata = await fetch(catUrl);
            podcaster = await data.json();
            categories = await catdata.json();
            console.log(categories);
            visPodcaster();
            //            opretKnapper();

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
            console.log(filterPodcast);

            visPodcaster();
        }

        function visPodcaster() {
            let temp = document.querySelector("template");
            let container = document.querySelector(".podcast_container");
            container.innerHTML = "";
            podcaster.forEach(podcast => {
                if (filterPodcast == "alle" || podcast.categories.includes(parseInt(filterPodcast))) {
                    let klon = temp.cloneNode(true).content;
                    klon.querySelector("h2").textContent = podcast.title.rendered;
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