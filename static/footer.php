<footer>
        
        <img id="footback" src=static/img/footer.jpg />
        <div>
            <a rel="Retour_Acceuil" href="https://bdw1.univ-lyon1.fr/p1702710/PROJET/VirtualForge/"> <img id="logopiedpage" src=static/img/LogoFinalAcceuil.png /></a>
        </div>

        
        <div id="nom_site">
            <em >2020 - Virtual Forge</em>
            <?php print date("Y"); ?>
        </div>

            <a href="http://liris.cnrs.fr/~fduchate/BDW1/"> <img id="BDW1logo" src=static/img/logobdw1.png />  </a>
            <a href="https://www.univ-lyon1.fr/">  <img id="UNIVlogo" src=static/img/UCBL-logo.png />  </a> <br>
            <a href="https://pixlr.com/fr/editor/"> <img id="PIXLRlogo" src=static/img/pixlr.png /> </a> <br>
        
        <div id="remerciment">
            <a > Remerciement </a><br>
            <li > Frank Favetta</li>
            <li > Fabien Duchateau</li>
            <li > Kevin</li>
        </div>
    </footer>
<script>
    document.addEventListener('click', function (event) {
        /*  
        var specifiedElement = document.getElementById('in');
        var is = specifiedElement.contains(event.target);
        if (is){
            alert('in');
        }
        */
        if (event.target.matches('.menu')){
            var el = document.querySelector('.menu-complet');
            el.classList.toggle('off-screen');
        }
        if (event.target.matches('.menu-complet')){
            var el = document.querySelector('.menu-complet');
            el.classList.toggle('off-screen');
        }

    },false)
</script>