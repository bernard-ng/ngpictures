
/**
 * premet de rendre un itme du menu active
 * @returns {boolean}
 */
function toggleMenuItem() {
    let active = document.querySelector("#menu-item-active").getAttribute('data-active');
    if (active !== undefined) {
        let link = document.querySelector("ul.links").querySelector("li#"+ active);
        link.classList.add('active');
    }
}

/**
 * premet de rendre un item du menu mobile active
 * @returns {boolean}
 */
function toggleMobileMenuItem() {
    let active = document.querySelector("#menu-mobile-item-active").getAttribute('data-active');
    if (active !== undefined) {
        let link = document.querySelector("ul.mobile-links").querySelector("li#"+ active);
        link.classList.add('active');
    }
}


/**
 * cree un timer relatif pour les dates
 */
function timer(){
    if (document.querySelectorAll('[data-time]') !== undefined) {
        if (NodeList.prototype.forEach === undefined) {
            NodeList.prototype.forEach = function (callback) {
                [].forEach.call(this, callback)
            }
        }

        let terms = [
            {time: 10, divide: 1, text: "%d secondes"},
            {time: 45, divide: 1, text: "moins d'une minute"},
            {time: 90, divide: 60, text: "environ une minute"},
            {time: 45 * 60, divide: 60, text: "%d minutes"},
            {time: 90 * 60, divide: 60 * 60 , text: "environ une heure"},
            {time: 24 * 60 * 60 , divide: 60 * 60 , text: "%d heures"},
            {time: 42 * 60 * 60 , divide: 24 * 60 * 60 , text: "environ un jour"},
            {time: 30 * 24 * 60 * 60, divide: 24 * 60 * 60 , text: "%d jours"},
            {time: 42 * 24 * 60 * 60 , divide: 24 * 60 * 60 * 30, text: "environ un mois"},
            {time: 365 * 24 * 60 * 60, divide: 24 * 60 * 60 * 30, text: "%d mois"},
            {time: 365 * 1.5 * 24 * 60 * 60 , divide: 24 * 60 * 60 * 365, text: "environ un an"},
            {time: Infinity, divide: 24 * 60 * 60 * 365 , text: "%d ans"}
        ];

        document.querySelectorAll('[data-time]').forEach(function(node) {
            function setText(){
                let seconds = Math.floor((new Date()).getTime()/1000 - parseInt(node.dataset.time, 10));
                let prefix = seconds > 0 ? 'Il y a ' : 'Dans ' ;
                let term = null;
                seconds = Math.abs(seconds);

                for (term of terms) {
                    if (seconds < term.time) {
                        break;
                    }
                }

                node.innerHTML = prefix + term.text.replace('%d', Math.round(seconds/term.divide));

                let nextTick = seconds % term.divide;
                if (nextTick === 0) {
                    nextTick = term.divide
                }
            }

            setText();

            window.setTimeout(function(){
                if (node.parentNode){
                    window.requestAnimationFrame ?  window.requestAnimationFrame(setText) : setText()
                }
            },  nextTick);
        })
    }
}

toggleMenuItem();
toggleMobileMenuItem();
timer();