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
<div class="splash">
    <div class="overlay_2">


        <?php
get_header();
?>
        <h1 class="lydfabrik">Danmarks <br> vildeste <br> lydfabrik</h1>

        <template>
            <article class="slide">
                <div class="hover_container">
                    <img class="episoder_img" src="" alt="">
                    <div class="overlay">
                        <h2></h2>
                        <p class="uddrag"></p>
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
        <h3>Populære podcasts</h3>
        <section class="episode_container slider"></section>
        <section id="lydunivers"></section>


        <section id="hvem_er_loud">
            <div class="col"></div>
            <div class="dybet"></div>
        </section>

        <!--        </div>  .singular-content-wrap -->
    </main><!-- #main -->

    <script>
        let episoder;
        let categories;
        let filterEpisode = "alle";

        const dbUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/episode?per_page=100";
        const catUrl = "http://mathildesahlholdt.com/kea/sem2/09_cms/loud/wp-json/wp/v2/categories";

        async function getJson() {
            console.log("getJson");
            const data = await fetch(dbUrl);
            const catdata = await fetch(catUrl);
            episoder = await data.json();
            categories = await catdata.json();
            console.log(categories);
            visEpisoder();
            //            opretKnapper();

        }

        function opretKnapper() {
            categories.forEach(cat => {
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-episode="${cat.id}">${cat.name}</button>`
            })

            addEventListenersToButtons();
        }

        function addEventListenersToButtons() {
            document.querySelectorAll("#filtrering button").forEach(elm => {
                elm.addEventListener("click", filtrering);
            })
        }

        function filtrering() {
            filterEpisode = this.dataset.episode;
            console.log(filterEpisode);

            visEpisoder();
        }

        function visEpisoder() {
            let temp = document.querySelector("template");
            let container = document.querySelector(".episode_container");
            container.innerHTML = "";
            episoder.forEach(episode => {
                if (filterEpisode == "alle" || episode.categories.includes(parseInt(filterEpisode))) {
                    let klon = temp.cloneNode(true).content;
                    klon.querySelector("h2").textContent = episode.title.rendered;
                    klon.querySelector("img").src = episode.billede.guid;
                    klon.querySelector(".uddrag").textContent = episode.uddrag; // klon.querySelector(".podcastnavn").textContent = episode.podcastnavn;
                    // klon.querySelector(".udgivelsesdato").textContent = episode.udgivelsesdato;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = episode.link;
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
